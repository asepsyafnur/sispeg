<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('golongan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('golongan.create');
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),['nama'=>'required|string|unique:golongans,nama'], $this->attributes());
        if($validator->fails()){
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        }else{
            try {
                Golongan::create([
                    'nama' => $request->nama
                ]);
                return response()->json([
                    'code' => 1, 
                    'msg' =>  'Satu data golongan berhasil ditambahkan'
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json(['code' => 0, 'msg' => $th->getErrors()]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Golongan  $golongan
     * @return \Illuminate\Http\Response
     */
    public function show(Golongan $golongan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Golongan  $golongan
     * @return \Illuminate\Http\Response
     */
    public function edit(Golongan $golongan)
    {
        return response()->json(['details' => $golongan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Golongan  $golongan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Golongan $golongan)
    {
        // $validator = Validator::make($request->all(),['nama'=>'required|string|unique:golongans,nama,' . $golongan->id], $this->attributes());
        // if($validator->fails()){
        //     return redirect()->back()->withInput($request->all())->withErrors($validator)->with('update_gagal', 'validator');
        // }
        // try {
        //    $golongan->update([
        //         'nama' => $request->nama
        //     ]);
        //     Alert::success('Sukses', 'data berhasil diubah');
        //     return redirect()->back();
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     Alert::error('Error', ['error' => $th->getMessage()]);
        //     return redirect()->back();
        // }
        $validator = Validator::make($request->all(),$request->all(),['nama'=>'required|string|unique:golongans,nama,' . $golongan->id], $this->attributes());
        if($validator->fails()){
            return response()->json(['code' => 0, 'msg' => 'ada masalah!!!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Golongan  $golongan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Golongan $golongan)
    {
        try {
            $golongan->delete();
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
            'nama.required' => "*golongan tidak boleh kosong",
            'nama.unique'   => "*data yang anda masukkan sudah digunakan"
        ];
    }

    public function golonganList()
    {
        return DataTables::of(Golongan::all())
                        ->addIndexColumn()
                        ->addColumn('aksi', function($row){
                            return '<div class="btn-group">
                                        <a class="btn btn-warning btn-sm" data-id="'.$row['id'].'" id="btnEdit" title="Edit" data-toggle="modal" data-target="#editModal">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>';})->rawColumns(['aksi'])->make(true);
    }

    public function golonganUpdate(Request $request)
    {
        $golonganId = $request->id;
        dd($golonganId);
    }
}
