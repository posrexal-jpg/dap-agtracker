<?php

namespace Tests\Feature;

use App\Models\Location;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LocationPhotoDeletionTest extends TestCase
{
    public function test_only_report_photo_files_are_removed(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('photos/report.jpg', 'report');
        Storage::disk('public')->put('photos/other.jpg', 'other');

        $location = new Location(['photo' => json_encode([
            'photos/report.jpg',
            '../other.jpg',
        ])]);
        $location->deleteUploadedPhotos();

        Storage::disk('public')->assertMissing('photos/report.jpg');
        Storage::disk('public')->assertExists('photos/other.jpg');
    }
}
