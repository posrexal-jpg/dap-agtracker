<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\ActivityType;
use App\Models\Municipality;
use App\Models\Notification;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MobileDataController extends Controller
{
    public function bootstrap(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'municipalities' => Municipality::orderBy('name')->pluck('name'),
            'activity_types' => ActivityType::where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->pluck('name'),
            'outbreak_threshold' => (int) Setting::get('outbreak_threshold', 25),
            'stats' => [
                'total_sightings' => Location::count(),
                'user_sightings' => Location::where('user_id', $user->id)->count(),
            ],
            'sightings' => Location::with('user:id,name')
                ->latest()
                ->limit(500)
                ->get()
                ->map(fn (Location $location) => $this->locationPayload($location)),
            'server_time' => now()->toIso8601String(),
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $query = Location::with('user:id,name')->latest();
        if ($request->filled('updated_since')) {
            $query->where('updated_at', '>', $request->date('updated_since'));
        }

        return response()->json([
            'sightings' => $query->limit(500)->get()
                ->map(fn (Location $location) => $this->locationPayload($location)),
            'server_time' => now()->toIso8601String(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'client_uuid' => ['required', 'uuid'],
            'name' => ['nullable', 'string', 'max:255'],
            'language' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string'],
            'location_name' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'number_of_cots' => ['nullable', 'string', 'max:50'],
            'early_juvenile' => ['nullable', 'integer', 'min:0'],
            'juvenile' => ['nullable', 'integer', 'min:0'],
            'sub_adult' => ['nullable', 'integer', 'min:0'],
            'adult' => ['nullable', 'integer', 'min:0'],
            'late_adult' => ['nullable', 'integer', 'min:0'],
            'activity_type' => ['nullable', 'string', 'max:100'],
            'activity_type_other' => ['nullable', 'string', 'max:255'],
            'observer_category' => ['nullable', 'string', 'max:100'],
            'survey_status' => ['nullable', 'in:Systematic survey,Opportunistic sighting'],
            'municipality' => ['nullable', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'date_of_sighting' => ['nullable', 'date'],
            'time_of_sighting' => ['nullable', 'date_format:H:i'],
            'observation_start_time' => ['nullable', 'date_format:H:i', 'required_with:observation_end_time'],
            'observation_end_time' => ['nullable', 'date_format:H:i', 'required_with:observation_start_time', 'after_or_equal:observation_start_time'],
            'observation_duration_minutes' => ['nullable', 'integer', 'min:0', 'max:1440'],
            'transect_length_m' => ['nullable', 'numeric', 'min:0'],
            'transect_width_m' => ['nullable', 'numeric', 'min:0'],
            'surveyed_area_m2' => ['nullable', 'numeric', 'min:0'],
            'depth_m' => ['nullable', 'numeric', 'min:0'],
            'water_visibility_m' => ['nullable', 'numeric', 'min:0'],
            'weather_sea_condition' => ['nullable', 'string', 'max:255'],
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
        ]);

        $user = $request->user();
        unset($data['photos']);
        $data['observation_duration_minutes'] = $this->durationMinutes(
            $data['observation_start_time'] ?? null,
            $data['observation_end_time'] ?? null
        );
        if (! isset($data['surveyed_area_m2']) && isset($data['transect_length_m'], $data['transect_width_m'])) {
            $data['surveyed_area_m2'] = $data['transect_length_m'] * $data['transect_width_m'];
        }

        $location = DB::transaction(function () use ($request, $user, $data) {
            $location = Location::firstOrNew([
                'user_id' => $user->id,
                'client_uuid' => $data['client_uuid'],
            ]);
            $location->fill($data);
            $location->user_id = $user->id;

            $photoPaths = $location->photo ? (json_decode($location->photo, true) ?: []) : [];
            // A client may retry after the server committed but before the
            // response arrived. Keep the first uploaded set idempotent too.
            if (empty($photoPaths)) {
                foreach ($request->file('photos', []) as $photo) {
                    $photoPaths[] = $photo->store('photos', 'public');
                }
            }
            $location->photo = json_encode(array_values(array_unique($photoPaths)));
            $location->save();

            Notification::firstOrCreate(
                ['type' => 'new_sighting', 'location_id' => $location->id],
                [
                    'user_id' => $user->id,
                    'title' => 'New COTS Sighting Reported',
                    'message' => "{$user->name} reported COTS at {$location->location_name}, {$location->municipality}, {$location->barangay}",
                    'is_read' => false,
                ]
            );

            return $location->load('user:id,name');
        });

        return response()->json([
            'message' => 'Sighting synchronized.',
            'sighting' => $this->locationPayload($location),
        ], $location->wasRecentlyCreated ? 201 : 200);
    }

    public function destroy(Request $request, Location $location): JsonResponse
    {
        abort_unless($location->user_id === $request->user()->id, 403);
        $location->delete();

        return response()->json(['message' => 'Sighting deleted.']);
    }

    private function locationPayload(Location $location): array
    {
        $payload = $location->toArray();
        $payload['outbreak_count'] = $location->outbreak_count;
        $paths = json_decode($location->photo ?: '[]', true) ?: [];
        $payload['photos'] = array_map(
            fn (string $path) => url(Storage::url($path)),
            $paths
        );
        unset($payload['photo']);

        return $payload;
    }

    private function durationMinutes(?string $start, ?string $end): ?int
    {
        if (! $start || ! $end) {
            return null;
        }

        [$startHour, $startMinute] = array_map('intval', explode(':', $start));
        [$endHour, $endMinute] = array_map('intval', explode(':', $end));

        return ($endHour * 60 + $endMinute) - ($startHour * 60 + $startMinute);
    }
}
