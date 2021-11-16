<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use Illuminate\Support\Facades\Validator;
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

    public function read()
    {
        $golongans = Golongan::orderBy('nama', 'desc')->get();
        return DataTables::of($golongans)
                        ->addIndexColumn()
                        ->addColumn('aksi', function($row){
                            return '<div class="btn-group">
                                        <button class="btn btn-sm btn-warning" data-id="'.$row['id'].'" id="btnEdit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="btnHapus" alert-text="Apakah anda yakin ingin menghapus golongan '.$row['nama'].'">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>';
                        })->rawColumns(['aksi'])->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),['nama'=>'required|string|unique:golongans,nama'], $this->attributes());
        if($validator->fails()){
            return response()->json(['code' => 400, 'error' => $validator->errors()->toArray()]);
        }else{
            try {
                Golongan::create([
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
        $golonganId = $request->id;
        $golongan = Golongan::find($golonganId);
        return response()->json(['details' => $golongan]);
    }

    public function update(Request $request)
    {
        $golonganId = $request->id;
        $golongan = Golongan::find($golonganId);
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|string|unique:golongans,nama,' . $golonganId
            ],$this->attributes());
        if($validator->fails()){
            return response()->json(['status' => 400, 'error' => $validator->errors()->toArray()]);
        }

        try {
            $golongan->update([
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
        $golonganId = $request->id;
        try {
            Golongan::find($golonganId)->delete();
            return response()->json(['status' => 200, 'msg' => 'Data berhasil dihapus']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 400, 'msg' => $th->getMessage()]);
        }
    }

    public function attributes()
    {
        return [
            'nama.required' => "*golongan tidak boleh kosong",
            'nama.unique'   => "*data yang anda masukkan sudah digunakan"
        ];
    }
}
