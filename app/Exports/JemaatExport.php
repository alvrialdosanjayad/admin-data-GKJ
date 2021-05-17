<?php

namespace App\Exports;

use App\Models\Jemaat;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class JemaatExport extends DefaultValueBinder implements WithCustomValueBinder, FromQuery, WithMapping, WithColumnFormatting, ShouldAutoSize, WithHeadings, WithStyles
{
    use Exportable;

    public function query()
    {
        return Jemaat::query();
    }

    public static function dateTimeToExcel($date)
    {
        if ($date == '') {
            return null;
        } elseif ($date == '0000-00-00') {
            return null;
        } else {
            $dateValue = new \DateTime($date);
            return Date::formattedPHPToExcel(
                (int) $dateValue->format('Y'),
                (int) $dateValue->format('m'),
                (int) $dateValue->format('d'),
                (int) $dateValue->format('H'),
                (int) $dateValue->format('i'),
                (int) $dateValue->format('s')
            );
        }
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_string($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }


    /**
     * @var Jemaat $invoice
     */
    public function map($invoice): array
    {

        return [
            $invoice->status_jemaat,
            $invoice->nama_lengkap,
            $invoice->no_kk,
            $invoice->hub_keluarga,
            $invoice->wilayah_gereja,
            $invoice->tempat_lahir,
            $this->dateTimeToExcel($invoice->tanggal_lahir),
            $invoice->jenis_kelamin,
            $invoice->golongan_darah,
            $invoice->alamat,
            $invoice->no_tlpn,
            $invoice->no_hp,
            $invoice->pendidikan,
            $invoice->pekerjaan,
            $invoice->nama_ayah,
            $invoice->nama_ibu,
            $invoice->status_nikah,
            $this->dateTimeToExcel($invoice->tgl_nikah),
            $invoice->gereja_nikah,
            $invoice->pendeta_nikah,
            $invoice->nama_suamiistri,
            $invoice->keadaan,
            $this->dateTimeToExcel($invoice->tgl_meninggal),
            $invoice->tempat_meninggal,
            $this->dateTimeToExcel($invoice->tgl_entri)

        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'R' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'W' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'Y' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function headings(): array
    {
        return [
            'statusjemaat',
            'namalengkap',
            'nomorkk',
            'hubkel',
            'wilayahgereja',
            'tempatlahir',
            'tanggallahir',
            'jeniskelamin',
            'goldarah',
            'alamat',
            'notelepon',
            'nohp',
            'pendidikan',
            'pekerjaan',
            'namaayah',
            'namaibu',
            'statuspernikahan',
            'tanggalmenikah',
            'gerejanikah',
            'pendetanikah',
            'namasuamiistri',
            'keadaan',
            'tanggalmeninggal',
            'tempatmeninggal',
            'tglentri'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            'A1' => ['font' => ['color' => array('rgb' => 'fc1303')]],
            'D1'  => ['font' => ['color' => array('rgb' => 'fc1303')]],
            'E1' => ['font' => ['color' => array('rgb' => 'fc1303')]],
            'H1'  => ['font' => ['color' => array('rgb' => 'fc1303')]],
            'I1'  => ['font' => ['color' => array('rgb' => 'fc1303')]],
            'M1' => ['font' => ['color' => array('rgb' => 'fc1303')]],
            'Q1' => ['font' => ['color' => array('rgb' => 'fc1303')]],
            'V1'  => ['font' => ['color' => array('rgb' => 'fc1303')]],
            'Y1'  => ['font' => ['color' => array('rgb' => 'fc1303')]]

        ];
    }
}
