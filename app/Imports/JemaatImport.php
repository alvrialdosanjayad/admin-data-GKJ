<?php

namespace App\Imports;

use App\Models\Jemaat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class JemaatImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return new Jemaat([
            //
            'kode_jemaat'  => $this->ambilKode($row),
            'nama_lengkap'    => $row['namalengkap'],
            'status_jemaat'    => $row['statusjemaat'],
            'no_kk'    => $row['nomorkk'],
            'hub_keluarga' => $row['hubkel'],
            'wilayah_gereja' => $row['wilayahgereja'],
            'tempat_lahir' => $row['tempatlahir'],
            'tanggal_lahir' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggallahir']),
            'jenis_kelamin' => $row['jeniskelamin'],

            'golongan_darah' => $row['goldarah'],
            'alamat' => $row['alamat'],
            'no_tlpn' => $row['notelepon'],
            'no_hp' => $row['nohp'],
            'pendidikan' => $row['pendidikan'],
            'pekerjaan' => $row['pekerjaan'],
            'nama_ayah' => $row['namaayah'],
            'nama_ibu' => $row['namaibu'],

            'status_nikah' => $row['statuspernikahan'],
            'tgl_nikah' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggalmenikah']),
            'gereja_nikah' => $row['gerejanikah'],
            'pendeta_nikah' => $row['pendetanikah'],
            'nama_suamiistri' => $row['namasuamiistri'],
            'keadaan' => $row['keadaan'],
            'tgl_meninggal' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggalmeninggal']),
            'tempat_meninggal' => $row['tempatmeninggal'],
            'tgl_entri' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tglentri']),
        ]);
    }

    protected function ambilKode(array $value)
    {

        $data = DB::table('jemaat')
            ->select(
                DB::raw('max(kode_jemaat) as id')
            )
            ->where('wilayah_gereja', $value['wilayahgereja'])
            ->first();

        $hasil = $data->id;
        $baru = (int) substr($hasil, 3);
        $baru++;
        $wilayah = sprintf("%02s", $value['wilayahgereja']);
        $kode = $wilayah . '.' . sprintf("%05s", $baru);
        $password = strtolower($value['tempatlahir']);

        DB::table('users')->insert([
            'username'  => $kode,
            'role'      => 'jemaat',
            'user' => $value['namalengkap'],
            'password'  => Hash::make($password),
            'created_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $kode;
    }
}
