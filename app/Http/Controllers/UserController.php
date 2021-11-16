<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Golongan;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('level', 'pegawai')->get();
        // $users = User::all();
        $golongans = Golongan::all();
        $jabatans = Jabatan::all();
        return view('users.index', compact('golongans', 'jabatans', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $golongans = Golongan::all();
        $jabatans = Jabatan::all();
        return view('users.create', compact('golongans', 'jabatans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'email' => 'required|unique:users,email',
                'nip' => 'required|unique:users,nip',
                'password' => 'required|min:6|confirmed',
                'golongan_id' => 'required',
                'jabatan_id' => 'required',
            ],$this->attributes());
        if($validatedData->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validatedData);
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'nip' => $request->nip,
                'password' => Hash::make($request->password),
                'golongan_id' =>  $request->golongan_id,
                'jabatan_id' => $request->jabatan_id,
                'level' => "pegawai"
            ]);
            Alert::success('Sukses', 'Data berhasil ditambahkan');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Gagal', ['error' => $th->getMessage()]);
            return redirect()->back()->withInput($request->all());
        }finally{
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {   
        $userId = Auth::user()->id;
        $user->where('user_id', $userId)->get()->first();
        $golongans = Golongan::all();
        $jabatans = Jabatan::all();
        return view('users.edit', compact('golongans', 'jabatans', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedData = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'email' => 'required|unique:users,email,' .$user->id,
                'nip' => 'required|unique:users,nip,' .$user->id,
                'golongan_id' => 'required',
                'jabatan_id' => 'required',
            ],$this->attributes());
        if($validatedData->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validatedData);
        }
        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'nip' => $request->nip,
                'golongan_id' => $request->golongan_id,
                'jabatan_id' => $request->jabatan_id,
            ]);
            Alert::success('Sukses', 'Data berhasil diubah');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Gagal', ['error' => $th->getMessage()]);
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */


    private function attributes(){
        return [
            'name.required' => '*nama tidak boleh kosong',
            'name.string' => '*nama harus menggunakan string',
            'email.required' => '*email tidak boleh kosong',
            'email.unique' => '*email sudah digunakan',
            'nip.required' => '*nip tidak boleh kosong',
            'nip.unique' => '*nip sudah digunakan',
            'password.required' => '*password tidak boleh kosong',
            'password.min' => '*password harus lebih dari 6 karakter',
            'password.confirmed' => '*konfirmasi password tidak sama',
            'golongan_id.required' => '*golongan tidak boleh kosong',
            'jabatan_id.required' => '*jabatan tidak boleh kosong',
        ];
    }
}
