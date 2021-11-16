<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jabatan.index');
    }

    public function read()
    {
        $jabatans = Jabatan::orderBy('nama', 'desc')->get();
        return DataTables::of($jabatans)
                        ->addIndexColumn()
                        ->addColumn('aksi', function($row){
                            return '<div class="btn-group">
                                        <button class="btn btn-sm btn-warning" data-id="'.$row['id'].'" id="btnEdit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="btnHapus" alert-text="Apakah anda yakin ingin menghapus jabatan '.$row['nama'].'">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>';
                        })->rawColumns(['aksi'])->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),['nama'=>'required|string|unique:jabatans,nama'], $this->attributes());
        if($validator->fails()){
            return response()->json(['code' => 400, 'error' => $validator->errors()->toArray()]);
        }else{
            try {
                jabatan::create([
                    'nama' => $request->nama
                ]);
                return response()->json(['code' => 200, 'msg' => 'Data berhasil ditambahkan']);
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json(['code' => 400, 'msg' => $th->getMessage()]);
            }
        }
    }

    public function edit(Request $request)
    {
        $jabatanId = $request->id;
        $jabatan = jabatan::find($jabatanId);
        return response()->json(['details' => $jabatan]);
    }

    public function update(Request $request)
    {
        $jabatanId = $request->id;
        $jabatan = Jabatan::find($jabatanId);
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|string|unique:jabatans,nama,' . $jabatanId
            ],$this->attributes());
        if($validator->fails()){
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        }

        try {
            $jabatan->update([
                'nama' => $request->nama
            ]);
            return response()->json(['status' => 200, 'msg' => 'Data berhasil diubah']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 400, 'msg' => $th->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        $jabatanId = $request->id;
        try {
            Jabatan::find($jabatanId)->delete();
            return response()->json(['status' => 200, 'msg' => 'Data berhasil dihapus']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 400, 'msg' => $th->getMessage()]);
        }
    }

    public function attributes()
    {
        return [
            'nama.required' => "*jabatan tidak boleh kosong",
            'nama.unique'   => "*data yang anda masukkan sudah digunakan"
        ];
    }
}
