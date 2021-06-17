<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class DashboardController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataJnsKelamin = $this->jenisKelamin();
        $totalData = $this->totalJemaat();
        $usiaJemaat = $this->usiaJemaat();
        $pendidikan = $this->pendidikan();
        return view('dashboard.index', compact('dataJnsKelamin', 'totalData', 'usiaJemaat', 'pendidikan'));
    }

    protected function totalJemaat()
    {
        # code...
        $totalData = DB::table('jemaat')
            ->select(
                DB::raw('count(*) as total'),
                DB::raw('AVG(YEAR(CURDATE()) - YEAR(tanggal_lahir)) AS totalUsia')
            )
            ->get();
        $totalData[0]->totalUsia = number_format($totalData[0]->totalUsia);

        return $totalData;
    }

    protected function jenisKelamin()
    {
        # code...
        $dataJnsKelamin = DB::table('jemaat')
            ->join('jenis_kelamin', 'jemaat.jenis_kelamin', 'jenis_kelamin.id')
            ->select(
                'jenis_kelamin.jenis_kelamin as name',
                DB::raw('(Count(jemaat.jenis_kelamin)* 100 / (Select Count(*) From jemaat)) as y'),
                DB::raw('count(jemaat.jenis_kelamin) as totalJnsKelamin')
            )
            ->groupBy('jenis_kelamin.jenis_kelamin')
            ->get();
        if ($dataJnsKelamin == "[]") {
            $data = '[{"name":"Laki-Laki","y":"0","totalJnsKelamin":0},{"name":"Perempuan","y":"0","totalJnsKelamin":0}]';
            $dataJnsKelamin = json_decode($data);
            return $dataJnsKelamin;
        } else {
            if ($dataJnsKelamin[0]->name == 'Laki-Laki' && count($dataJnsKelamin) == 1) {
                $data =
                    '[
                        {"name":"' . $dataJnsKelamin[0]->name . '","y":"' . $dataJnsKelamin[0]->y . '","totalJnsKelamin":' . $dataJnsKelamin[0]->totalJnsKelamin .
                    '},{"name":"Perempuan","y":"0","totalJnsKelamin":0' .
                    '}]';
                $dataJnsKelamin = json_decode($data);
                return $dataJnsKelamin;
            } elseif ($dataJnsKelamin[0]->name == 'Perempuan' && count($dataJnsKelamin) == 1) {
                $data =
                    '[
                        {"name":"Laki-Laki","y":"0","totalJnsKelamin":0}' .
                    ',{"name":"' . $dataJnsKelamin[0]->name . '","y":"' . $dataJnsKelamin[0]->y . '","totalJnsKelamin":' . $dataJnsKelamin[0]->totalJnsKelamin .
                    '}]';
                $dataJnsKelamin = json_decode($data);
                return $dataJnsKelamin;
            } else {
                return $dataJnsKelamin;
            }
        }
    }

    protected function usiaJemaat()
    {
        # code...
        $queryUmur = DB::table('jemaat')
            ->select(DB::raw("TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) AS umur"))
            ->toSql();
        $data = DB::table(DB::raw("({$queryUmur}) as sub"))
            ->select(
                DB::raw(
                    "CASE
                        WHEN umur <= 15 THEN '0 - 15'
                        WHEN umur BETWEEN 16 and 27 THEN '16 - 27'
                        WHEN umur BETWEEN 28 and 40 THEN '28 - 40'
                        WHEN umur >= 41 THEN '41 - ...'
                        WHEN umur IS NULL THEN '(NULL)'
                    END as name,
                    COUNT(*) AS y"
                )
            )
            ->groupBy('name')
            ->get();

        $dataUmur = collect();
        $dataUmur = $data;
        $dataUmur->shift();
        $dataUmur->toJson();
        return $dataUmur;
    }

    protected function pendidikan()
    {
        # code...
        $dataPendidikan = DB::table('jemaat')
            ->join('pendidikan', 'jemaat.pendidikan', 'pendidikan.id')
            ->select(
                'pendidikan.pendidikan as name',
                DB::raw('COUNT(jemaat.pendidikan) as y')
            )
            ->groupBy('pendidikan.pendidikan')
            ->orderBy('pendidikan.id')
            ->get();

        return $dataPendidikan;
    }
}
