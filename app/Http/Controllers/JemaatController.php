<?php

namespace App\Http\Controllers;

use App\Models\HubKeluarga;
use App\Models\Wilayah;
use App\Models\JenisKelamin;
use App\Models\Goldar;
use App\Models\Jemaat;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\StatusNikah;
use App\Models\Keadaan;
use App\Models\StatusJemaat;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Auth\Events\Registered;

use Illuminate\Http\Request;

class JemaatController extends Controller
{
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
        return view('jemaat.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $hubKeluarga = HubKeluarga::all();
        $wilayah = Wilayah::all();
        $jnsKelamin = JenisKelamin::all();
        $golDarah = Goldar::all();
        $pendidikan = Pendidikan::all();
        $statusNikah = StatusNikah::all();
        $keadaan = Keadaan::all();
        $status_jemaat = StatusJemaat::all();

        return view('jemaat.tambahJemaat', compact('hubKeluarga', 'wilayah', 'jnsKelamin', 'golDarah', 'pendidikan', 'statusNikah', 'keadaan', 'status_jemaat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $fileName = null;
        if ($request->noTelp == null) {
            $validatedData = $request->validate([
                'noKk' => 'numeric',
                'suratBaptis' => 'mimes:jpg,bmp,png',
            ]);
        } else {
            $validatedData = $request->validate([
                'noKk' => 'numeric',
                'suratBaptis' => 'mimes:jpg,bmp,png',
            ]);
        }

        if ($request->hasFile('suratBaptis')) {
            //
            $namaFile = str_replace(" ", "", $request->namaLengkap);
            $fileName = 'Surat_Baptis_' . $namaFile . '.' . $request->file('suratBaptis')->extension();

            $request->file('suratBaptis')->move(public_path('/surat-baptis'),  $fileName);
        }

        $data = $this->ambilKode($request->wilGereja);

        $jemaat = new Jemaat;
        $jemaat->kode_jemaat = $data;
        $jemaat->status_jemaat = $request->statusjemaat;
        $jemaat->nama_lengkap = $request->namaLengkap;
        $jemaat->no_kk = $request->noKk;
        $jemaat->hub_keluarga = $request->hubKeluarga;
        $jemaat->wilayah_gereja = $request->wilGereja;
        $jemaat->tempat_lahir = $request->tempatLahir;
        $jemaat->tanggal_lahir = $request->tglLahir;
        $jemaat->jenis_kelamin = $request->jnsKelamin;
        $jemaat->golongan_darah = $request->golDarah;
        $jemaat->alamat = $request->alamat;
        $jemaat->no_tlpn = $request->noTelp;
        $jemaat->no_hp = $request->noHp;
        $jemaat->pendidikan = $request->pendidikan;
        $jemaat->pekerjaan = $request->pekerjaan;
        $jemaat->nama_ayah = $request->namaAyah;
        $jemaat->nama_ibu = $request->namaIbu;
        $jemaat->status_nikah = $request->statusNikah;
        $jemaat->tgl_nikah = $request->tglNikah;
        $jemaat->foto_surat_baptis = $fileName;
        $jemaat->gereja_nikah = $request->grjNikah;
        $jemaat->pendeta_nikah = $request->pdtNikah;
        $jemaat->nama_suamiistri = $request->namaSuamiIstri;
        $jemaat->keadaan = $request->keadaan;
        $jemaat->tgl_meninggal = $request->tglMeninggal;
        $jemaat->tempat_meninggal = $request->tmptMeninggal;
        $jemaat->tgl_entri = date('Y-m-d H:i:s');

        $jemaat->save();

        event(new Registered($this->createUser($data)));

        $id  = DB::table('jemaat')->select(DB::raw('kode_jemaat AS id'))->where('kode_jemaat', $data)->first();

        return redirect('/jemaat/' . Crypt::encryptString($id->id))->with('status', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($data)
    {
        //
        $id = Crypt::decryptString($data);
        $jemaat = DB::table('jemaat')
            ->join('hubungan_keluarga', 'jemaat.hub_keluarga', 'hubungan_keluarga.id')
            ->join('wilayah', 'jemaat.wilayah_gereja', 'wilayah.id')
            ->join('jenis_kelamin', 'jemaat.jenis_kelamin', 'jenis_kelamin.id')
            ->join('goldar', 'jemaat.golongan_darah', 'goldar.id')
            ->join('pendidikan', 'jemaat.pendidikan', 'pendidikan.id')
            ->join('status_nikah', 'jemaat.status_nikah', 'status_nikah.id')
            ->join('keadaan', 'jemaat.keadaan', 'keadaan.id')
            ->join('status_jemaat', 'jemaat.status_jemaat', 'status_jemaat.id')
            ->select(
                'jemaat.*',
                'hubungan_keluarga.hub_keluarga',
                'wilayah.wilayah',
                'jenis_kelamin.jenis_kelamin',
                'goldar.golangan_darah',
                'pendidikan.pendidikan',
                'status_nikah.status_nikah',
                'keadaan.status_keadaan',
                'status_jemaat.status_jemaat'
            )
            ->where('kode_jemaat', $id)
            ->first();


        return view('jemaat.tampilJemaat', compact('jemaat', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = Crypt::decryptString($id);
        $jemaat = Jemaat::where('kode_jemaat', $data)->first();
        $hubKeluarga = HubKeluarga::all();
        $statusJemaat = StatusJemaat::all();
        $wilayah = Wilayah::all();
        $jnsKelamin = JenisKelamin::all();
        $golDarah = Goldar::all();
        $pendidikan = Pendidikan::all();
        $statusNikah = StatusNikah::all();
        $keadaan = Keadaan::all();
        return view('jemaat.ubahJemaat', compact('jemaat', 'hubKeluarga', 'statusJemaat',  'wilayah', 'jnsKelamin', 'golDarah', 'pendidikan', 'statusNikah', 'keadaan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = DB::table('jemaat')->select('foto_surat_baptis')->where('kode_jemaat', $id)->first();
        $fileName = $data->foto_surat_baptis;
        if ($request->noTelp == null) {
            $validatedData = $request->validate([
                'noKk' => 'numeric',
                'suratBaptis' => 'mimes:jpg,bmp,png',
            ]);
        } else {
            $validatedData = $request->validate([
                'noKk' => 'numeric',
                'suratBaptis' => 'mimes:jpg,bmp,png',
            ]);
        }

        if ($request->hasFile('suratBaptis')) {
            //
            $namaFile = str_replace(" ", "", $request->namaLengkap);
            $fileName = 'Surat_Baptis_' . $namaFile . '.' . $request->file('suratBaptis')->extension();

            $request->file('suratBaptis')->move(public_path('/surat-baptis'),  $fileName);
        }

        Jemaat::where('kode_jemaat', $id)->update([
            'nama_lengkap' => $request->namaLengkap,
            'no_kk' => $request->noKk,
            'hub_keluarga' => $request->hubKeluarga,
            'wilayah_gereja' => $request->wilGereja,
            'tempat_lahir' => $request->tempatLahir,
            'tanggal_lahir' => $request->tglLahir,
            'jenis_kelamin' => $request->jnsKelamin,
            'golongan_darah' => $request->golDarah,
            'alamat' => $request->alamat,
            'no_tlpn' => $request->noTelp,
            'no_hp' => $request->noHp,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'nama_ayah' => $request->namaAyah,
            'nama_ibu' => $request->namaIbu,
            'status_nikah' => $request->statusNikah,
            'tgl_nikah' => $request->tglNikah,
            'foto_surat_baptis' => $fileName,
            'gereja_nikah' => $request->grjNikah,
            'pendeta_nikah' => $request->pdtNikah,
            'nama_suamiistri' => $request->namaSuamiIstri,
            'keadaan' => $request->keadaan,
            'tgl_meninggal' => $request->tglMeninggal,
            'tempat_meninggal' => $request->tmptMeninggal
        ]);

        return redirect('/jemaat/' . Crypt::encryptString($id))->with('status', 'Data Berhasil Di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = DB::table('jemaat')->select('foto_surat_baptis')->where('kode_jemaat', $id)->first();
        Storage::disk('hosting')->delete("surat-baptis/" . $data->foto_surat_baptis);
        User::where('username', $id)->delete();
        $post = Jemaat::where('kode_jemaat', $id)->delete();
        return response()->json($post);
    }

    /**
     * ambil data untuk filter wilayah atau jenis kelamin
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getData($data)
    {
        //
        if ($data == "5") {
            $post = Wilayah::all();
            return response()->json($post);
        } elseif ($data == "6") {
            $post = JenisKelamin::all();
            return response()->json($post);
        } else {
            $post = Pendidikan::all();
            return response()->json($post);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDownload($namaFile)
    {
        //
        try {
            //code...
            return Storage::disk('hosting')->download("surat-baptis/" . $namaFile);
        } catch (\Exception $e) {
            //throw $th;
            return $e->getMessage();
        }
    }

    public function dataTabel(Request $request)
    {
        # code...
        if ($request->ajax()) {
            $jemaat = DB::table('jemaat')
                ->join('wilayah', 'jemaat.wilayah_gereja', 'wilayah.id')
                ->join('jenis_kelamin', 'jemaat.jenis_kelamin', 'jenis_kelamin.id')
                ->join('pendidikan', 'jemaat.pendidikan', 'pendidikan.id')
                ->select(
                    'jemaat.kode_jemaat',
                    'jemaat.no_kk',
                    'jemaat.nama_lengkap',
                    'jemaat.no_hp',
                    'jemaat.alamat',
                    DB::raw('DATE_FORMAT(jemaat.tanggal_lahir, "%d %M %Y") AS tanggal'),
                    DB::raw('IF(jemaat.foto_surat_baptis = 0, "sudah", "belum") AS baptis'),
                    'wilayah.wilayah',
                    'jenis_kelamin.jenis_kelamin',
                    'pendidikan.pendidikan'
                )
                ->get();
            return DataTables::of($jemaat)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $enkripsi = Crypt::encryptString($data->kode_jemaat);
                    $url = url('/jemaat/' . $enkripsi . '');
                    $button = '<div class="d-flex justify-content-center">';
                    $button .= '<a href="' . $url . '" class="edit btn btn-info btn-sm edit-post"><i class="fa fa-info-circle"></i></a>';
                    $button .= '&nbsp;&nbsp;&nbsp';
                    $button .= '<button type="button" name="delete" id="' . $data->kode_jemaat . '" class="delete btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>';
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
    protected function ambilKode($value)
    {
        $data = DB::table('jemaat')
            ->select(
                DB::raw('max(kode_jemaat) as id')
            )
            ->where('wilayah_gereja', $value)
            ->first();

        $hasil = $data->id;
        $baru = (int) substr($hasil, 3);
        $baru++;
        $wilayah =  sprintf("%02s", $value);
        $kode = $wilayah . '.' . sprintf("%05s", $baru);

        return $kode;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\User
     */
    protected function createUser($data)
    {
        return User::create([
            'username' => $data,
            'role' => 'jemaat',
            'password' => Hash::make('12345678'),
        ]);
    }
}
