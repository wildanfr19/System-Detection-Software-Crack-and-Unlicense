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
     * Cache koleksi agar tidak query ulang saat styling.
     */
    private ?Collection $cached = null;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if ($this->cached !== null) {
            return $this->cached;
        }

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
            // (kolom ownership dihilangkan sesuai permintaan)

            // Tentukan department berdasarkan pc_name atau user_name (sesuaikan dengan logic bisnis Anda)
            $department = $this->getDepartmentFromPcName($pcName);

            // PIC (Person In Charge) - bisa diambil dari user_name atau sesuaikan dengan kebutuhan
            $pic = $firstLog->user_name ?: 'N/A';
            $hasDetectedApps = !empty($applications);
            $licenseStatus = $hasDetectedApps ? '-' : '✓';      // Kosong jika ada apps terdeteksi
            $unlicenseStatus = $hasDetectedApps ? '✓' : '-';

            $exportData->push([
                $rowNumber,                 // A: NO
                $pcName,                    // B: COMPUTER NAME
                $firstLog->mac_address,     // C: MAC ADDRESS
                'ITSA',                     // D: COMPANY (default)
                $pic,                       // E: PIC
                $department,                // F: DEPARTMENT
                $applications,              // G: SOFTWARE NAME
                $licenseStatus,             // H: LICENCE
                $unlicenseStatus,           // I: UNLICENCE
                '',                         // J: ACTION
                ''                          // K: Signature
            ]);

            $rowNumber++;
        }

        // cache result untuk dipakai kembali di styles()
        return $this->cached = $exportData;
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
            'A' => 5,    // NO
            'B' => 18,   // COMPUTER NAME
            'C' => 18,   // MAC ADDRESS
            'D' => 12,   // COMPANY
            'E' => 14,   // PIC
            'F' => 16,   // DEPARTMENT
            'G' => 42,   // SOFTWARE NAME
            'H' => 12,   // LICENCE
            'I' => 12,   // UNLICENCE
            'J' => 12,   // ACTION
            'K' => 14,   // Signature
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

        // Merge cells untuk subheader computer checking result (2 kolom: H-J)
        $sheet->mergeCells('H5:J5');
        $sheet->setCellValue('H5', 'COMPUTER CHECKING RESULT');
        $sheet->getStyle('H5')->applyFromArray([
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
        $sheet->getStyle('A6:K6')->applyFromArray([
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
        $sheet->getStyle('A7:K' . $lastRow)->applyFromArray([
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
    $sheet->getStyle('H7:J' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Auto-fit row height
        for ($row = 7; $row <= $lastRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1);
        }

        return [];
    }
}
