<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WartaJemaat;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class WartaController extends Controller
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
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = WartaJemaat::orderBy('tanggal', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $url = url('download/warta/' . $data->nama_warta);
                    $button = '<div class="d-flex justify-content-center">';
                    $button .= '<button data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-info btn-sm edit-post mr-2"><i class="far fa-edit"></i></button>';
                    $button .= '<a href="' . $url . '" class="download btn btn-primary btn-sm mr-2"><i class="fa fa-download"></i></a>';
                    $button .= '<button type="button" name="delete" id="' . $data->nama_warta . '" class="delete btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>';

                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        // echo public_path();

        return view('warta.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDownloadWarta($namaFile)
    {
        //
        try {
            //code...
            return Storage::disk('hosting')->download("warta-jemaat/" . $namaFile);
        } catch (\Exception $e) {
            //throw $th;
            return $e->getMessage();
        }
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
        if ($request->status == "update") {
            $post = $this->validate($request, [
                'fileWarta' => 'required|mimes:pdf'
            ]);
            $fileName = 'Warta_Jemaat_' . $request->tanggal . '.' . $request->file('fileWarta')->extension();

            $post = $request->file('fileWarta')->move(public_path('/warta-jemaat'),  $fileName);

            return response()->json($post);
        } else {
            $post = $this->validate($request, [
                'fileWarta' => 'required|mimes:pdf',
                'tanggal' => 'required|unique:warta'
            ]);

            $fileName = 'Warta_Jemaat_' . $request->tanggal . '.' . $request->file('fileWarta')->extension();

            $post = $request->file('fileWarta')->move(public_path('/warta-jemaat'),  $fileName);

            WartaJemaat::create([
                'tanggal' => $request->tanggal,
                'nama_warta' => $fileName
            ]);

            return response()->json($post);
        }
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
        $where = array('id' => $id);
        $post  = WartaJemaat::where($where)->first();

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $post = Storage::disk('hosting')->delete("warta-jemaat/" . $id);
        WartaJemaat::where('nama_warta', $id)->delete();

        return response()->json($post);
    }
}
