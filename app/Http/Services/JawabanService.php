<?php

namespace App\Http\Services;

use App\Http\Traits\PenilaianTraits;
use App\Http\Utils\HasilPerkembangan;
use App\Http\Utils\Pertumbuhan;
use App\Http\Utils\Rekomendasi;
use App\Http\Utils\Tindakan;
use App\Models\Jawaban;
use App\Models\Perkembangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JawabanService  
{
    use PenilaianTraits;

    public static function kirimJawaban($request){
        
        try {
            Jawaban::create([
                'users_id'                   => Auth::user()->id,
                'username'                   => Auth::user()->username,
                'nama_lengkap'               => Auth::user()->nama_lengkap,
                'nim'                        => Auth::user()->nim,
                'nama_balita'                => $request->nama_balita,
                'tanggal_lahir'              => Carbon::parse($request->tanggal_lahir)->format('Y-d-m'),
                'tanggal_pemeriksaan'        => Carbon::parse($request->tanggal_pemeriksaan)->format('Y-d-m'),
                'nama_ibu'                   => $request->nama_ibu,
                'alamat'                     => $request->alamat,
                'usia_dalam_bulan'           => $request->usia_dalam_bulan,
                'jenis_kelamin'              => $request->jenis_kelamin,
                'berat'                      => $request->berat,
                'panjang'                    => $request->panjang,
                'rentang_usia'               => $request->rentang_usia,
                "kode_pertumbuhan"           => $request->kode_pertumbuhan,
                "kode_rekomendasi"           => $request->kode_rekomendasi,
                "kode_tindakan_perkembangan" => $request->kode_tindakan_perkembangan,
                "jadwal_pertumbuhan"         => Carbon::parse($request->tanggal_lahir)->addMonths(1)->format('Y-d-m'),
                "jadwal_perkembangan"        => $request->jadwal_perkembangan,
                "jawaban_array"              => $request->jawaban_array,
            ]);
            return response()->json([
                "success"  => true,
                "message " => "Berhasil Mengirim jawaban"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success"  => false,
                "message " => "Gagal Mengirim jawaban". $th
            ]);
        }
    }

    public static function getHistoriJawabanByUser(){
        $jawaban =  Jawaban::where('users_id', Auth::user()->id)->select(['id','nama_balita','tanggal_lahir','tanggal_pemeriksaan'])->get();
        return response()->json([
            "success"          => true,
            "histori_jawaban " => Auth::user()->username. "(".Auth::user()->nim.")",
            "data"             => $jawaban
        ]);
    }

    public static function getHistoriJawabanByAdmin(){
        if(Auth::user()->username=='admin'){
            $jawaban = Jawaban::select(['id','nama_balita','tanggal_lahir','tanggal_pemeriksaan', 'username','nim','nama_lengkap'])->get();
            return response()->json([
                "success"  => true,
                "message " => "Data histori jawaban seluruh user",
                "data"     => $jawaban
            ]);
        }
        else{
            return response()->json([
                "success"  => false,
                "message " => "anda tidak diberikan hak akses untuk mengakses endpoint ini"
            ]);
        }
    }

    public  function getHistoriJawabanDetail($id){
        $jawaban_detail = Jawaban::find($id);
        
        $usia_bayi = $this->getRentangBulan(Carbon::parse($jawaban_detail->tanggal_lahir)->format('d-m-Y'));
    
        $perkembangan = Perkembangan::whereRelation('usia_bayi', 'rentang', '=', $usia_bayi)
        ->select(['text', 'gambar'])
        ->get();

        $array = json_decode($jawaban_detail->jawaban_array, TRUE);
    
        $perkembangan->each(function($item, $key) use ($array) { 
            $item['jawaban'] = $array[$key];
        })->all();
    
        $response = [
            'success' => true,
            'message' => 'jawaban penilaian user',
            'data'    => [
                'pemeriksa' => [ 
                    'nim'                 => Auth::user()->nim,
                    'username'            => Auth::user()->username,
                    'nama_lengkap'        => Auth::user()->username,
                    'tanggal_pemeriksaan' => Carbon::parse($jawaban_detail->tanggal_pemeriksaan)->format('d-m-Y')
                ],
                'balita' => [
                    'nama'          => $jawaban_detail->nama_balita,
                    'panjang'       => $jawaban_detail->panjang ." cm",
                    'berat'         => $jawaban_detail->berat. " kg",
                    'jenis_kelamin' => $jawaban_detail->jenis_kelamin,
                    'nama_ibu'      => $jawaban_detail->nama_ibu,
                    'alamat'        => $jawaban_detail->alamat,
                    'tanggal_lahir' => Carbon::parse($jawaban_detail->tanggal_lahir)->format('d-m-Y'),
                ],
                'pertumbuhan' => [
                    "kode_pertumbuhan"   => $jawaban_detail->kode_pertumbuhan,
                    "status_pertumbuhan" => Pertumbuhan::getStatusPertumbuhan($jawaban_detail->kode_pertumbuhan),
                    "kode_rekomendasi"   => $jawaban_detail->kode_rekomendasi,
                    "status_rekomendasi" => Rekomendasi::getStatusRekomendasi($jawaban_detail->kode_pertumbuhan)
                ],
                'perkembangan' => [
                    "hasil"               => HasilPerkembangan::getHasilPerkembangan($jawaban_detail->kode_tindakan_perkembangan),
                    "tindakan"            => Tindakan::getTindakan($jawaban_detail->kode_tindakan_perkembangan),
                    "jadwal_pertumbuhan"  => Carbon::parse($jawaban_detail->jadwal_pertumbuhan)->format('d-m-Y'),
                    "jadwal_perkembangan" => HasilPerkembangan::HASIL_JADWAL
                ],
                'jawaban' => $perkembangan 
            ]  
        ];

        return response()->json($response);
    }
}