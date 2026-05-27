<?php

namespace App\Helpers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExcelExportHelper
{
    /**
     * Generate and stream a beautifully styled XLSX Excel spreadsheet.
     *
     * @param string $filename Name of the output file (without extension)
     * @param array $headers List of header strings
     * @param array $rows Two-dimensional array of data rows
     * @param string $sheetTitle Title of the worksheet
     * @return StreamedResponse
     */
    public static function exportToXlsx(string $filename, array $headers, array $rows, string $sheetTitle = 'Data')
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($sheetTitle);

        // Premium Styling Configurations
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
                'name' => 'Segoe UI',
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FF8A3D'], // Vibrant Saffron Accent
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '1E3A8A'], // Classic Navy Border Accent
                ],
            ],
        ];

        $rowStyleEven = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F8FAFC'], // Soft Slate/Gray Zebra Row
            ],
        ];

        // Populate Headers
        $colIndex = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($colIndex . '1', $header);
            $colIndex++;
        }

        // Apply styling to header row
        $lastColNumber = ord('A') + count($headers) - 1;
        // Support columns past Z just in case (AA, AB...)
        $lastCol = self::getColLetters(count($headers));
        
        $sheet->getStyle('A1:' . $lastCol . '1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Populate Data Rows
        $rowIndex = 2;
        foreach ($rows as $row) {
            $colIndex = 'A';
            foreach ($row as $value) {
                // Keep data clean and cast to string to prevent formula injections
                $sheet->setCellValue($colIndex . $rowIndex, $value);
                $colIndex++;
            }

            // Zebra striping for even rows
            if ($rowIndex % 2 === 0) {
                $sheet->getStyle('A' . $rowIndex . ':' . $lastCol . $rowIndex)->applyFromArray($rowStyleEven);
            }

            // Thin border gridline mapping
            $sheet->getStyle('A' . $rowIndex . ':' . $lastCol . $rowIndex)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
                ->getColor()
                ->setRGB('E2E8F0');
                
            $sheet->getRowDimension($rowIndex)->setRowHeight(22);
            $rowIndex++;
        }

        // Auto-fit Column Widths dynamically with a padding offset
        $colIndex = 'A';
        for ($i = 0; $i < count($headers); $i++) {
            $currentCol = self::getColLetters($i + 1);
            $sheet->getColumnDimension($currentCol)->setAutoSize(true);
        }

        $response = new StreamedResponse(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '_' . date('Y-m-d') . '.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }

    /**
     * Helper to resolve column index to Excel column letters (A, B... Z, AA, AB...).
     */
    private static function getColLetters(int $columnNumber): string
    {
        $letters = '';
        while ($columnNumber > 0) {
            $modulo = ($columnNumber - 1) % 26;
            $letters = chr(65 + $modulo) . $letters;
            $columnNumber = (int)(($columnNumber - $modulo) / 26);
        }
        return $letters;
    }
}
