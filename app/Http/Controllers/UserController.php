<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Jemaat;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if (Gate::allows('isSuperAdmin')) {
            if ($request->ajax()) {
                $data = DB::table('users')
                    ->leftJoin('jemaat', 'users.username', 'jemaat.kode_jemaat')
                    ->select(
                        'jemaat.nama_lengkap',
                        'users.username',
                        'users.role',
                        'users.id'
                    )
                    ->where('username', '!=', 'admin')
                    ->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {
                        if($data->role == 'admin'){
                            $button = '<div class="d-flex justify-content-center">';
                            $button .= '<button type="button" name="delete" id="' . $data->username . '" class="delete btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>';
                            $button .= '</div>';
                            return $button;
                        }
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }
            

            return view('user.index');
        } else {
            abort(403, 'admin');
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
        if (Gate::allows('isSuperAdmin')) {
            $data = $request->validate([
                'username' => 'required|string|max:255|unique:users|alpha_dash',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $data = event(new Registered($data = $this->createUser($request->all())));

            return response()->json($data);
        } else {
            abort(403, 'admin');
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
        if (Gate::allows('isSuperAdmin') || Gate::allows('isAdmin')) {
            $dekripsi = Crypt::decryptString($id);
            $post  = User::where('id', $dekripsi)->first();

            return view('user.ubahData', compact('post'));
        } else {
            abort(403, 'admin');
        }
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
        if (Gate::allows('isSuperAdmin') || Gate::allows('isAdmin')) {
            $data = $request->validate([
                'password' => 'required|string|min:8|confirmed'
            ]);

            $data = User::find($id)->update([
                'username' => $request->username,
                'role' => 'admin',
                'password' => Hash::make($request->password)
            ]);
            $enkripsi = Crypt::encryptString($id);
            return redirect('/user/edituser/' . $enkripsi)->with('status', 'Data Berhasil Diubah');
        } else {
            abort(403, 'admin');
        }
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
        if (Gate::allows('isSuperAdmin')) {
            User::where('username', $id)->delete();
            $post = Jemaat::where('kode_jemaat', $id)->delete();

            return response()->json($post);
        } else {
            abort(403, 'admin');
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function createUser(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'role' => 'admin',
            'password' => Hash::make($data['password']),
        ]);
    }
}
