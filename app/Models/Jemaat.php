<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jemaat extends Model
{
    use HasFactory;
    protected $table = 'jemaat';
    protected $fillable = [
        'kode_jemaat',
        'status_jemaat',
        'nama_lengkap',
        'no_kk',
        'hub_keluarga',
        'wilayah_gereja',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'alamat',
        'no_tlpn',
        'no_hp',
        'pendidikan',
        'pekerjaan',
        'nama_ayah',
        'nama_ibu',
        'status_nikah',
        'tgl_nikah',
        'gereja_nikah',
        'pendeta_nikah',
        'nama_suamiistri',
        'keadaan',
        'tgl_meninggal',
        'tempat_meninggal',
        'foto_surat_baptis',
        'tgl_entri',
    ];

    protected $primaryKey = 'kode_jemaat';

    protected $casts = [
        'no_kk' => 'string',
        'kode_jemaat' => 'string'
    ];
    public $timestamps = false;
}
