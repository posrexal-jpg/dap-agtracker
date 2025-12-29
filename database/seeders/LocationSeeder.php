<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::create([
            'name' => 'Sample COTS Sighting 1',
            'description' => 'First test sighting of Crown-of-Thorns Starfish',
            'latitude' => 10.3157,
            'longitude' => 123.8854,
            'number_of_cots' => 15,
            'early_juvenile' => 5,
            'juvenile' => 3,
            'sub_adult' => 4,
            'adult' => 3,
            'activity_type' => 'Feeding',
            'observer_category' => 'Researcher',
            'municipality' => 'Bacolod City',
            'barangay' => 'Barangay 1',
            'date_of_sighting' => '2024-12-01',
            'time_of_sighting' => '10:30:00',
        ]);

        Location::create([
            'name' => 'Sample COTS Sighting 2',
            'description' => 'Second test sighting near coral reef',
            'latitude' => 10.3200,
            'longitude' => 123.8900,
            'number_of_cots' => 8,
            'early_juvenile' => 2,
            'juvenile' => 2,
            'sub_adult' => 3,
            'adult' => 1,
            'activity_type' => 'Moving',
            'observer_category' => 'Diver',
            'municipality' => 'Bacolod City',
            'barangay' => 'Barangay 2',
            'date_of_sighting' => '2024-12-15',
            'time_of_sighting' => '14:20:00',
        ]);

        Location::create([
            'name' => 'Sample COTS Sighting 3',
            'description' => 'Third sighting in different municipality',
            'latitude' => 10.2800,
            'longitude' => 123.8500,
            'number_of_cots' => 22,
            'early_juvenile' => 8,
            'juvenile' => 6,
            'sub_adult' => 5,
            'adult' => 3,
            'activity_type' => 'Spawning',
            'observer_category' => 'Local Fisherman',
            'municipality' => 'Talisay City',
            'barangay' => 'Barangay A',
            'date_of_sighting' => '2024-11-20',
            'time_of_sighting' => '09:15:00',
        ]);
    }
}