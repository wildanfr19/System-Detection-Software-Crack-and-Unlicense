<?php

namespace App\Exports;

use App\Models\DetectionLog;
use Illuminate\Support\Collection;
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

class CleanPcExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle, WithCustomStartCell
{
    private ?Collection $cached = null;

    public function collection()
    {
        if ($this->cached !== null) {
            return $this->cached;
        }

        $cleanLogs = DetectionLog::select([
                'pc_name',
                'user_name',
                'ip_address',
                'mac_address',
                'detected_at',
                'created_at'
            ])
            ->where('source', 'Clean PC')
            ->orderBy('pc_name')
            ->orderByDesc('detected_at')
            ->get()
            ->groupBy('pc_name');

        $exportData = collect();
        $rowNumber = 1;
        foreach ($cleanLogs as $pcName => $rows) {
            $latest = $rows->sortByDesc('detected_at')->first();
            $department = $this->getDepartmentFromPcName($pcName);
            $pic = $latest->user_name ?: 'N/A';

            // Clean PC: tidak ada software terdeteksi → Licence ✓, Unlicence -
            $applications = '';
            $licenseStatus = '✓';
            $unlicenseStatus = '-';

            $exportData->push([
                $rowNumber,                 // A: NO
                $pcName,                    // B: COMPUTER NAME
                $latest->mac_address,       // C: MAC ADDRESS
                'ITSA',                     // D: COMPANY
                $pic,                       // E: PIC
                $department,                // F: DEPARTMENT
                $applications,              // G: SOFTWARE NAME (kosong)
                $licenseStatus,             // H: LICENCE
                $unlicenseStatus,           // I: UNLICENCE
                '',                         // J: ACTION
                ''                          // K: Signature
            ]);

            $rowNumber++;
        }

        return $this->cached = $exportData;
    }

    private function getDepartmentFromPcName($pcName)
    {
        $u = strtoupper($pcName);
        if (strpos($u, 'SYD') !== false || strpos($u, 'IT') !== false) return 'SYD & IT';
        if (strpos($u, 'PURCHASE') !== false || strpos($u, 'PURCHASING') !== false) return 'PURCHASING';
        if (strpos($u, 'ASSIST') !== false) return 'ASSISTEN MD';
        if (strpos($u, 'ACCOUNT') !== false) return 'ACCOUNTING';
        if (strpos($u, 'MARKETING') !== false) return 'MARKETING';
        if (strpos($u, 'LEGAL') !== false || strpos($u, 'HRGA') !== false) return 'HRGA&LEGAL';
        return 'UNKNOWN';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 18,
            'C' => 18,
            'D' => 12,
            'E' => 14,
            'F' => 16,
            'G' => 42,
            'H' => 12,
            'I' => 12,
            'J' => 12,
            'K' => 14,
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
            'Signature',
        ];
    }

    public function title(): string
    {
        return 'Clean PC Report';
    }

    public function startCell(): string
    {
        return 'A6';
    }

    public function styles(Worksheet $sheet)
    {
        // Judul utama
        $sheet->mergeCells('A1:M1');
        $sheet->setCellValue('A1', 'SUMMARY OF CLEAN PC - PT. ITSA');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [ 'bold' => true, 'size' => 14 ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [ 'fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E6E6E6'] ],
        ]);

        // Subheader: COMPUTER CHECKING RESULT (kolom H-J)
        $sheet->mergeCells('H5:J5');
        $sheet->setCellValue('H5', 'COMPUTER CHECKING RESULT');
        $sheet->getStyle('H5')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [ 'fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D0E0E3'] ],
        ]);

        // Header baris 6
        $sheet->getStyle('A6:K6')->applyFromArray([
            'font' => [ 'bold' => true, 'color' => ['rgb' => 'FFFFFF'] ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [ 'fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4472C4'] ],
            'borders' => [ 'allBorders' => [ 'borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000'] ] ],
        ]);

        $dataRowCount = $this->collection()->count();
        $lastRow = 6 + $dataRowCount;

        $sheet->getStyle('A7:K' . $lastRow)->applyFromArray([
            'borders' => [ 'allBorders' => [ 'borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000'] ] ],
            'alignment' => [ 'vertical' => Alignment::VERTICAL_CENTER ],
        ]);

        $sheet->getStyle('A7:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H7:J' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        for ($row = 7; $row <= $lastRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1);
        }

        return [];
    }
}
