<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jabatans = Jabatan::all();
        return view('jabatan.index', compact('jabatans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|string|unique:jabatans,nama'
            ],$this->attributes());
        if($validator->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validator)->with('createFail', 'oke');
        }

        try {
            Jabatan::create([
                'nama' => $request->nama
            ]);
            Alert::success('Sukses', 'Data berhasil ditambahkan');
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Gagal', ['error' => $th->getMessage()]);
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Jabatan $jabatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|string|unique:jabatans,nama,' . $jabatan->id
            ],$this->attributes());
        if($validator->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validator)->with('editFail', 'oke');
        }

        try {
            $jabatan->update([
                'nama' => $request->nama
            ]);
            Alert::success('Sukses', 'Data berhasil diubah');
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Gagal', ['error' => $th->getMessage()]);
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jabatan $jabatan)
    {
        try {
            $jabatan->delete();
            Alert::success('Sukses', 'Data berhasil dihapus');
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Gagal', ['error' => $th->getMessage()]);
            return redirect()->back();
        }
    }

    public function attributes()
    {
        return [
            'nama.required' => "*jabatan tidak boleh kosong",
            'nama.unique' => "*nama yang anda masukkan sudah digunakan",
            'nama.string' => "*silahkan gunakan string",
        ];
    }
}
