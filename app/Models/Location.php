<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Location extends Model
{
    use HasFactory;

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
        'observer_category',
        'municipality',
        'barangay',
        'date_of_sighting',
        'time_of_sighting',
        'photo',
    ];

    /**
     * Get the user that owns the location.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
