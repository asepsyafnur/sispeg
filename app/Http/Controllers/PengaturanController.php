<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Golongan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PengaturanController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $jabatans = Jabatan::all();
        $golongans = Golongan::all();
        $pengaturan = User::where('id', $userId)->get()->first();
        return view('pengaturan.index', compact('pengaturan', 'jabatans', 'golongans'));   
    }

    public function update(Request $request)
    {
        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->get()->first();
        $userPass = User::select('password')->where('id', $userId)->get()->first();
        if(is_null($request->password)){
            $password = 'confirmed';
        }else{
            $password = 'confirmed|min:6';
        }
        $validatedData = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'email' => 'required|unique:users,email,' .$user->id,
                'nip' => 'required|unique:users,nip,' .$user->id,
                'password' => $password,
                'golongan_id' => 'required',
                'jabatan_id' => 'required',
            ],$this->attributes());
        if($validatedData->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validatedData);
        }
        try {
            if(is_null($request->password)){
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'nip' => $request->nip,
                    'golongan_id' => $request->golongan_id,
                    'jabatan_id' => $request->jabatan_id,
                ]);
            }else{
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'nip' => $request->nip,
                    'golongan_id' => $request->golongan_id,
                    'jabatan_id' => $request->jabatan_id,
                    'password' => Hash::make($request->password)
                ]);
            }
            
            Alert::success('Sukses', 'Data berhasil diubah');
            return redirect()->route('pengaturan.index');
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Gagal', ['error' => $th->getMessage()]);
            return redirect()->back()->withInput($request->all());
        }
    }

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
