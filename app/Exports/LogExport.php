<?php

namespace App\Exports;

use App\Models\DetectionLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Collection;

class LogExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle, WithCustomStartCell
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $detectionLogs = DetectionLog::select([
            'pc_name',
            'user_name',
            'ip_address',
            'mac_address',
            'app_name',
            'path',
            'source',
            'detected_at',
            'created_at'
        ])
            ->orderBy('pc_name')
            ->orderBy('detected_at')
            ->get();

        // Group data berdasarkan pc_name
        $groupedData = $detectionLogs->groupBy('pc_name');

        $exportData = collect();
        $rowNumber = 1;
        foreach ($groupedData as $pcName => $logs) {
            $firstLog = $logs->first();
            $applications = $logs->pluck('app_name')->unique()->implode(', ');

            // Tentukan ownership (asumsi company jika tidak ada user_name yang spesifik)
            $personalOwnership = !empty($firstLog->user_name) ? '✓' : '';
            $companyOwnership = empty($firstLog->user_name) ? '✓' : '';

            // Tentukan department berdasarkan pc_name atau user_name (sesuaikan dengan logic bisnis Anda)
            $department = $this->getDepartmentFromPcName($pcName);

            // PIC (Person In Charge) - bisa diambil dari user_name atau sesuaikan dengan kebutuhan
            $pic = $firstLog->user_name ?: 'N/A';
            $hasDetectedApps = !empty($applications);
            $licenseStatus = $hasDetectedApps ? '-' : '✓';      // Kosong jika ada apps terdeteksi
            $unlicenseStatus = $hasDetectedApps ? '✓' : '-';

            $exportData->push([
                $rowNumber,                                    // NO
                $pcName,                                      // COMPUTER NAME
                $firstLog->mac_address,                       // MAC ADDRESS
                'ITSA',                                       // COMPANY (default)
                $pic,                                         // PIC
                $department,                                  // DEPARTMENT
                $personalOwnership,                           // OWNERSHIP - PERSONAL
                $companyOwnership,                            // OWNERSHIP - COMPANY
                $applications,                                // SOFTWARE NAME (list of detected apps)
                $licenseStatus,                                         // LICENCE (default unlicensed)
                $unlicenseStatus,                                          // UNLICENCE
                '',                                          // ACTION
                ''                                           // Signature
            ]);

            $rowNumber++;
        }

        return $exportData;
    }
    private function getDepartmentFromPcName($pcName)
    {

        if (strpos(strtoupper($pcName), 'SYD') !== false || strpos(strtoupper($pcName), 'IT') !== false) {
            return 'SYD & IT';
        } elseif (strpos(strtoupper($pcName), 'PURCHASE') !== false || strpos(strtoupper($pcName), 'PURCHASING') !== false) {
            return 'PURCHASING';
        } elseif (strpos(strtoupper($pcName), 'ASSIST') !== false) {
            return 'ASSISTEN MD';
        } elseif (strpos(strtoupper($pcName), 'ACCOUNT') !== false) {
            return 'ACCOUNTING';
        } elseif (strpos(strtoupper($pcName), 'MARKETING') !== false) {
            return 'MARKETING';
        } elseif (strpos(strtoupper($pcName), 'LEGAL') !== false || strpos(strtoupper($pcName), 'HRGA') !== false) {
            return 'HRGA&LEGAL';
        } else {
            return 'UNKNOWN';
        }
    }
    public function columnWidths(): array
    {
        return [
            'A' => 5,   // NO
            'B' => 15,  // COMPUTER NAME
            'C' => 18,  // MAC ADDRESS
            'D' => 10,  // COMPANY
            'E' => 12,  // PIC
            'F' => 15,  // DEPARTMENT
            'G' => 10,  // PERSONAL
            'H' => 10,  // COMPANY
            'I' => 40,  // SOFTWARE NAME
            'J' => 10,  // LICENCE
            'K' => 12,  // UNLICENCE
            'L' => 12,  // ACTION
            'M' => 12,  // Signature
        ];
    }
    public function headings(): array
    {
        return [
            'NO',
            'COMPUTER NAME',
            'MAC ADDRESS',
            'COMPANY',
            'PIC',
            'DEPARTMENT',
            'PERSONAL',
            'COMPANY',
            'SOFTWARE NAME',
            'LICENCE',
            'UNLICENCE',
            'ACTION',
            'Signature'
        ];
    }
    public function title(): string
    {
        return 'Detection Log Report';
    }

    /**
     * @return string
     */
    public function startCell(): string
    {
        return 'A6'; // Mulai dari baris 6 untuk memberikan ruang untuk header
    }
    public function styles(Worksheet $sheet)
    {
        // Merge cells untuk judul
        $sheet->mergeCells('A1:M1');
        $sheet->setCellValue('A1', 'SUMMARY OF COMPUTER CHECKING RESULT ILLEGAL SOFTWARE - PT. ITSA');

        // Style untuk judul
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'E6E6E6'],
            ],
        ]);

        // Merge cells untuk subheader ownership
        $sheet->mergeCells('G5:H5');
        $sheet->setCellValue('G5', 'OWNERSHIP');
        $sheet->getStyle('G5')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'D0E0E3'],
            ],
        ]);

        // Merge cells untuk subheader computer checking result
        $sheet->mergeCells('I5:K5');
        $sheet->setCellValue('I5', 'COMPUTER CHECKING RESULT');
        $sheet->getStyle('I5')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'D0E0E3'],
            ],
        ]);

        // Style untuk header (baris 6)
        $sheet->getStyle('A6:M6')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => '4472C4'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Hitung jumlah baris data
        $dataRowCount = $this->collection()->count();
        $lastRow = 6 + $dataRowCount;

        // Style untuk data rows
        $sheet->getStyle('A7:M' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style khusus untuk kolom tertentu
        $sheet->getStyle('A7:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G7:H' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J7:K' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Auto-fit row height
        for ($row = 7; $row <= $lastRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1);
        }

        return [];
    }
}
