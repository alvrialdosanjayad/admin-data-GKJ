<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Wilayah;

use Yajra\DataTables\Facades\DataTables;

class WilayahController extends Controller
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
            // dd($request->ajax());
            $data = Wilayah::orderBy('id', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<div class="d-flex justify-content-center">';
                    $button .= '<button data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-info btn-sm edit-post mr-2"><i class="far fa-edit"></i></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>';
                    $button .= '</div>';

                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('wilayah.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $post = $this->validate($request, [
            'wilayah' => 'required|unique:wilayah'
        ]);

        $id = $request->kodeWilayah;
        $post = Wilayah::updateOrCreate(
            ['id' => $id],
            ['wilayah' => $request->wilayah]
        );

        return response()->json($post);
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
        $post  = Wilayah::where($where)->first();

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
        //
        $post = Wilayah::where('id', $id)->delete();

        return response()->json($post);
    }
}
