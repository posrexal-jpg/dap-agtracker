<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Location extends Model
{
    use HasFactory;

    protected $appends = ['outbreak_count'];

    protected static function booted(): void
    {
        static::deleted(fn (Location $location) => $location->deleteUploadedPhotos());
    }

    public function deleteUploadedPhotos(): void
    {
        $paths = json_decode($this->photo ?: '[]', true);
        if (! is_array($paths)) {
            return;
        }

        $safePaths = array_filter($paths, fn ($path) => is_string($path)
            && str_starts_with($path, 'photos/')
            && ! str_contains($path, '..'));
        if ($safePaths) {
            Storage::disk('public')->delete(array_values($safePaths));
        }
    }

    
    protected $fillable = [
        'client_uuid',
        'user_id',
        'name',
        'language',
        'description',
        'location_name',
        'latitude',
        'longitude',
        'number_of_cots',
        'early_juvenile',
        'juvenile',
        'sub_adult',
        'adult',
        'late_adult',
        'activity_type',
        'activity_type_other',
        'observer_category',
        'survey_status',
        'municipality',
        'barangay',
        'date_of_sighting',
        'time_of_sighting',
        'observation_start_time',
        'observation_end_time',
        'observation_duration_minutes',
        'transect_length_m',
        'transect_width_m',
        'surveyed_area_m2',
        'depth_m',
        'water_visibility_m',
        'weather_sea_condition',
        'photo',
    ];

    protected $casts = [
        'transect_length_m' => 'decimal:2',
        'transect_width_m' => 'decimal:2',
        'surveyed_area_m2' => 'decimal:2',
        'depth_m' => 'decimal:2',
        'water_visibility_m' => 'decimal:2',
    ];

    public function getOutbreakCountAttribute(): int
    {
        return (int) $this->adult + (int) $this->late_adult;
    }

    /**
     * Get the user that owns the location.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
