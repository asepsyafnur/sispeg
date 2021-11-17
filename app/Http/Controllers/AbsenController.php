<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use PDF;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $tglHariIni = date('Y-m-d');
        $absens = Absen::where('user_id', $userId)->get();

        $cekAbsensi = Absen::where(['user_id' => $userId, 'tanggal' => $tglHariIni])->get()->first();
        if(is_null($cekAbsensi)){
            $info = [
                'status' => "Jangan Lupa Absen Masuk Hari ini",
                'alert' => 'alert-info',
                'masuk' => '',
                'keluar' => 'disabled'
            ];
        }elseif($cekAbsensi->kepulangan == NULL){
            $info = [
                'status' => "Jangan Lupa Absen Dulu Baru Pulang",
                'alert' => 'alert-warning',
                'masuk' => 'disabled',
                'keluar' => ''
            ];
        }else{
            $info = [
                'status' => "Absen Hari ini Sudah Selesai, Selamat Beristirahat!!!",
                'alert' => 'alert-success',
                'masuk' => 'disabled',
                'keluar' => 'disabled'
            ];
        }
        return view('absen.index', compact('absens', 'info'));
    }

    public function store(Request $request)
    {
        $absen = new Absen;
        $userId = Auth::user()->id;
        $tglHariIni = date('Y-m-d');

        $cekAbsensi = $absen->where(['user_id' => $userId, 'tanggal' => $tglHariIni])->count();
        if(!is_null($request->masuk)){
            if($cekAbsensi > 0){
                Alert::warning('Oppps', 'hari ini anda sudah mengisi absen masuk');
                return redirect()->back();
            }
            $absen->create([
                'user_id' => Auth::user()->id,
                'tanggal' => $tglHariIni,
                'kedatangan' => date('H:i:s'),
            ]);
            Alert::success('Hore', 'kamu telah melakukan absen masuk hari ini');
            return redirect()->back();
        }elseif(!is_null($request->keluar)){
            $absen->where(['user_id' => $userId, 'tanggal' => $tglHariIni])->update([
                'kepulangan' => date('H:i:s'),
                'keterangan' => $request->keterangan
            ]);
            Alert::success('Hore', 'kamu telah melakukan absen keluar hari ini');
            return redirect()->back();
        }
    }

    public function read()
    {
        $pegawais = Absen::all();
        $statuses = $this->status();
        return view('absen.read', compact('pegawais', 'statuses'));
    }

    public function update(Request $request)
    {
        $absenId = $request->id;
        $absen = Absen::find($absenId);
        $absen->status = $request->status;
        try {
            $absen->save();
            Alert::success('Sukses', 'status berhasil di konfirmasi');
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Sukses', $th->getMessage());
            return redirect()->back();
        }
    }

    public function exportpdf(){
        $pegawais = Absen::orderBy('tanggal', 'desc')->get();
        view()->share('pegawais', $pegawais);
        $pdf = PDF::loadView('absen.datapegawai-pdf');
        $str = Str::random(10);
        return $pdf->download($str.'.pdf');
    }

    public function status()
    {
        return [
            'belum konfirmasi' => 'belum konfirmasi',
            'hadir' => 'hadir',
            'alpa' => 'alpa',
            'izin' => 'izin',
            'sakit' => 'sakit'
        ];
    }
}
