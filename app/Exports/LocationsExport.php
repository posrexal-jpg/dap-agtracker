<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class LocationsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $locations;

    public function __construct($locations)
    {
        $this->locations = $locations;
    }

    // The data to export
    public function collection()
    {
        return $this->locations->map(function ($location) {
            return [
                'Name' => $location->name,
                'Description' => $location->description,
                'Municipality' => $location->municipality,
                'barangay' => $location->barangay,
                'Number of Cots' => $location->number_of_cots,
                'early_juvenile' => $location->early_juvenile,
                'juvenile' => $location->juvenile,
                'sub_adult' => $location->sub_adult,
                'adult' => $location->adult,
                'late_adult' => $location->late_adult,
                'Date of Sighting' => $location->date_of_sighting, // Add this field
                'Time of Sighting' => $location->time_of_sighting, // Add this field
                'Latitude' => $location->latitude, // Add this field
                'Longitude' => $location->longitude, // Add this field
                'Activity Type' => $location->activity_type, // Add this field
                'Activity Type Other' => $location->activity_type_other,
                'Observer Category' => $location->observer_category, // Add this field
                'Survey Status' => $location->survey_status,
                'Observation Start' => $location->observation_start_time,
                'Observation End' => $location->observation_end_time,
                'Observation Duration (minutes)' => $location->observation_duration_minutes,
                'Transect Length (m)' => $location->transect_length_m,
                'Transect Width (m)' => $location->transect_width_m,
                'Surveyed Area (m²)' => $location->surveyed_area_m2,
                'Depth (m)' => $location->depth_m,
                'Water Visibility (m)' => $location->water_visibility_m,
                'Weather / Sea Condition' => $location->weather_sea_condition,
                'Outbreak Count (Adult + Senescence)' => $location->outbreak_count,
            ];
        });
    }

    // Add headings to the Excel sheet
    public function headings(): array
    {
        return [
            'Name',
            'Description',
            'Municipality',
            'Barangay',
            'Number of Cots',
            '1-5cm',
            '6-15cm',
            '16-25cm',
            '26-35cm',
            '>35cm',
            'Date of Sighting',
            'Time of Sighting',
            'Latitude',
            'Longitude',
            'Activity Type',
            'Activity Type Other',
            'Observer Category',
            'Survey Status',
            'Observation Start',
            'Observation End',
            'Observation Duration (minutes)',
            'Transect Length (m)',
            'Transect Width (m)',
            'Surveyed Area (m²)',
            'Depth (m)',
            'Water Visibility (m)',
            'Weather / Sea Condition',
            'Outbreak Count (Adult + Senescence)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply bold styling to the header row
        $lastColumn = 'AC';
        $sheet->getStyle("A1:{$lastColumn}1")->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle("A1:{$lastColumn}1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Apply background color to header row
        $sheet->getStyle("A1:{$lastColumn}1")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(Color::COLOR_YELLOW);

        // Add borders to all cells containing data
        $sheet->getStyle('A2:' . $lastColumn . (count($this->locations) + 1))
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Set alignment for all data cells
        $sheet->getStyle('A2:' . $lastColumn . (count($this->locations) + 1))
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Adjust column width for better visibility
        for ($index = 1; $index <= 29; $index++) {
            $column = Coordinate::stringFromColumnIndex($index);
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [];
    }
}
