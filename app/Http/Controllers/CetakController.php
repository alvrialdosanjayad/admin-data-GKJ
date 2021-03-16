<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Crypt;

class CetakController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     * 
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:isAdmin');
    }

    public function jemaatCetak($id)
    {
        # code...
        $data = Crypt::decryptString($id);
        $jemaat = DB::table('jemaat')
            ->join('hubungan_keluarga', 'jemaat.hub_keluarga', 'hubungan_keluarga.id')
            ->join('wilayah', 'jemaat.wilayah_gereja', 'wilayah.id')
            ->join('jenis_kelamin', 'jemaat.jenis_kelamin', 'jenis_kelamin.id')
            ->join('goldar', 'jemaat.golongan_darah', 'goldar.id')
            ->join('pendidikan', 'jemaat.pendidikan', 'pendidikan.id')
            ->join('status_nikah', 'jemaat.status_nikah', 'status_nikah.id')
            ->join('keadaan', 'jemaat.keadaan', 'keadaan.id')
            ->select(
                'jemaat.*',
                'hubungan_keluarga.hub_keluarga',
                'wilayah.wilayah',
                'jenis_kelamin.jenis_kelamin',
                'goldar.golangan_darah',
                'pendidikan.pendidikan',
                'status_nikah.status_nikah',
                'keadaan.status_keadaan'
            )
            ->where('kode_jemaat', $data)
            ->first();

        $data = [
            'cek' => $jemaat,
            'tanggal' => date('d F Y')
        ];

        $namaFile = str_replace(" ", "", $jemaat->nama_lengkap);

        $pdf = PDF::loadView('cetak.filePdfJemaat', $data)->setPaper('a4', 'potrait')->setWarnings(false);
        return $pdf->download('Data-jemaat-' . $namaFile . '.pdf');
    }

    public function tampilViewCetak()
    {
        //
        return view('cetak.cetakData');
    }

    public function getDataFilterCetak($data)
    {
        $hasilData = DB::table($data)
            ->select('id', $data . ' as data')
            ->get();
        return response()->json($hasilData);
    }

    public function dataCetak(Request $request)
    {
        if ($request->filterCetak == 'umur') {
            return $this->umurCetak2($request);
        } elseif ($request->filterCetak == 'semua') {
            return $this->semuaCetak();
        } else {
            if ($request->filterCetak == 'wilayah') {
                $request->filterCetak = 'wilayah_gereja';
            }
            $jumlahData = DB::table('jemaat')->where($request->filterCetak, '=', $request->kategoriCetak)->count();
            if ($jumlahData > 0) {
                $data = DB::table('jemaat')
                    ->join('wilayah', 'jemaat.wilayah_gereja', 'wilayah.id')
                    ->join('jenis_kelamin', 'jemaat.jenis_kelamin', 'jenis_kelamin.id')
                    ->join('pendidikan', 'jemaat.pendidikan', 'pendidikan.id')
                    ->select(
                        'jemaat.no_kk',
                        'jemaat.nama_lengkap',
                        'jemaat.no_hp',
                        'jemaat.alamat',
                        'jemaat.tanggal_lahir',
                        'jemaat.pekerjaan',
                        'wilayah.wilayah',
                        'jenis_kelamin.jenis_kelamin',
                        'pendidikan.pendidikan'
                    )
                    ->where('jemaat.' . $request->filterCetak, $request->kategoriCetak)
                    ->get();

                $coba = [
                    'cek' => $data,
                    'jumlah_data' => $jumlahData,
                    'tanggal' => date('d F Y'),
                    'dataUmur' => 'tidak ada'
                ];

                $pdf = PDF::loadView('cetak.filePdfData', $coba)->setPaper('a4', 'landscape')->setWarnings(false);
                return $pdf->download('Data-jemaat.pdf');
            } else {
                return redirect('/cetak')->with('status', 'Data Tidak Ada');
            }
        }
    }

    protected function umurCetak2($data)
    {
        $queryUmur = DB::table('jemaat')
            ->select(DB::raw("TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) AS umur"))
            ->toSql();
        $queryUmurData = DB::table('jemaat')
            ->join('wilayah', 'jemaat.wilayah_gereja', 'wilayah.id')
            ->join('jenis_kelamin', 'jemaat.jenis_kelamin', 'jenis_kelamin.id')
            ->join('pendidikan', 'jemaat.pendidikan', 'pendidikan.id')
            ->select(
                'jemaat.no_kk',
                'jemaat.nama_lengkap',
                'jemaat.no_hp',
                'jemaat.alamat',
                'jemaat.tanggal_lahir',
                'jemaat.pekerjaan',
                'wilayah.wilayah',
                'jenis_kelamin.jenis_kelamin',
                'pendidikan.pendidikan',
                DB::raw("TIMESTAMPDIFF(YEAR, jemaat.tanggal_lahir, CURDATE()) AS umur")
            )
            ->toSql();
        if ($data->kategoriCetak == 'kurangdari') {

            $jumlahData = DB::table(DB::raw("({$queryUmur}) as sub"))
                ->where('umur', '<', $data->umur1)
                ->count();
            if ($jumlahData > 0) {
                $data = DB::table(DB::raw("({$queryUmurData}) as sub"))
                    ->where('umur', '<', $data->umur1)
                    ->get();
                $coba = [
                    'cek' => $data,
                    'jumlah_data' => $jumlahData,
                    'tanggal' => date('d F Y'),
                    'dataUmur' => 'ada'
                ];

                $pdf = PDF::loadView('cetak.filePdfData', $coba)->setPaper('a4', 'landscape')->setWarnings(false);
                return $pdf->download('Data-jemaat.pdf');
            } else {
                return redirect('/cetak')->with('status', 'Data Tidak Ada');
            }
        } elseif ($data->kategoriCetak == 'diantara') {

            $jumlahData = DB::table(DB::raw("({$queryUmur}) as sub"))
                ->whereBetween('umur', [$data->umur1, $data->umur2])
                ->count();
            if ($jumlahData > 0) {
                $data = DB::table(DB::raw("({$queryUmurData}) as sub"))
                    ->whereBetween('umur', [$data->umur1, $data->umur2])
                    ->get();
                $coba = [
                    'cek' => $data,
                    'jumlah_data' => $jumlahData,
                    'tanggal' => date('d F Y'),
                    'dataUmur' => 'ada'
                ];

                $pdf = PDF::loadView('cetak.filePdfData', $coba)->setPaper('a4', 'landscape')->setWarnings(false);
                return $pdf->download('Data-jemaat.pdf');
            } else {
                return redirect('/cetak')->with('status', 'Data Tidak Ada');
            }
        } else {
            $jumlahData = DB::table(DB::raw("({$queryUmur}) as sub"))
                ->where('umur', '>', $data->umur1)
                ->count();
            if ($jumlahData > 0) {
                $data = DB::table(DB::raw("({$queryUmurData}) as sub"))
                    ->where('umur', '>', $data->umur1)
                    ->get();
                $coba = [
                    'cek' => $data,
                    'jumlah_data' => $jumlahData,
                    'tanggal' => date('d F Y'),
                    'dataUmur' => 'ada'
                ];

                $pdf = PDF::loadView('cetak.filePdfData', $coba)->setPaper('a4', 'landscape')->setWarnings(false);
                return $pdf->download('Data-jemaat.pdf');
            } else {
                return redirect('/cetak')->with('status', 'Data Tidak Ada');
            }
        }
    }

    protected function semuaCetak()
    {
        # code...
        $jumlahData = DB::table('jemaat')->count();
        if ($jumlahData > 0) {
            $data = DB::table('jemaat')
                ->join('wilayah', 'jemaat.wilayah_gereja', 'wilayah.id')
                ->join('jenis_kelamin', 'jemaat.jenis_kelamin', 'jenis_kelamin.id')
                ->join('pendidikan', 'jemaat.pendidikan', 'pendidikan.id')
                ->select(
                    'jemaat.no_kk',
                    'jemaat.nama_lengkap',
                    'jemaat.no_hp',
                    'jemaat.alamat',
                    'jemaat.tanggal_lahir',
                    'jemaat.pekerjaan',
                    'wilayah.wilayah',
                    'jenis_kelamin.jenis_kelamin',
                    'pendidikan.pendidikan'
                )
                ->get();

            $coba = [
                'cek' => $data,
                'jumlah_data' => $jumlahData,
                'tanggal' => date('d F Y'),
                'dataUmur' => 'tidak ada'
            ];

            $pdf = PDF::loadView('cetak.filePdfData', $coba)->setPaper('a4', 'landscape')->setWarnings(false);
            return $pdf->download('Data-jemaat.pdf');
        } else {
            return redirect('/cetak')->with('status', 'Data Tidak Ada');
        }
    }
}
