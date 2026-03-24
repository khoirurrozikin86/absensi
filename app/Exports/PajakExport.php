<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Pajak;

class PajakExport implements FromQuery, WithColumnFormatting, WithMapping, WithHeadings,ShouldAutoSize,WithStyles
{
    use Exportable;

    public function styles(Worksheet $sheet)
    {
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        //BORDER
        $sheet->getStyle("A1:$highestColumn" . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // HEADER
        $sheet->getStyle("A1:" . $highestColumn . "1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // WRAP TEXT
        $sheet->getStyle("A1:$highestColumn" . $highestRow)->getAlignment()->setWrapText(true);

        // ALIGNMENT TEXT
        $sheet->getStyle("A1:$highestColumn" . $highestRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

        //BOLD FIRST ROW
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Pegawai',
            'Bulan',
            'Tahun',
            'Status Pajak',
            'Penghasilan Bruto',
            'Penghasilan Netto Sebulan',
            'Penghasilan Netto Setahun',
            'PTKP',
            'PKP',
            'PPH 21 Setahun',
            'PPH 21 Sebulan',
        ];
    }

    public function map($model): array
    {
        return [
            $model->user->name,
            $model->bulan,
            $model->tahun,
            $model->status_ptkp->name,
            $model->penghasilan_bruto,
            $model->penghasilan_netto_bulan,
            $model->penghasilan_netto_tahun,
            $model->ptkp,
            $model->pkp,
            $model->pph21_setahun,
            $model->pph21_perbulan,
        ];
        
    }

    public function columnFormats(): array
    {
        return [

        ];
    }

    public function query()
    {
        return Pajak::dataPajak();
    }
}
