<?php

namespace App\Http\Services;


use App\Http\Utils\HasilPerkembangan;
use App\Http\Utils\Pertumbuhan;
use App\Http\Utils\Rekomendasi;
use App\Http\Utils\Tindakan;
use App\Models\Jawaban;
use App\Models\Perkembangan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JawabanService  
{
   

    public function kirimJawaban($request){

        //validasi jawaban array, jumlah jawaban array wajib sama dengan jumlah soal+judul
        
        if((new CekArrayJawaban)->invalid($request)){
            return response()->json([
                "success" => false,
                "message" => "jumlah jawaban_array tidak sama dengan pertanyaan perkembangan"
            ]);
        }
        
        $tgl_lahir_only_date = Carbon::parse($request->tanggal_lahir)->format('d');
        $tgl_pemeriksaan = Carbon::now()->addMonths(1)->format('m-Y');

        $jadwal_pertumbuhan = Carbon::parse($tgl_lahir_only_date .'-'. $tgl_pemeriksaan)->format('Y-m-d'); 
      
        try {
            Jawaban::create([
                'users_id'                   => Auth::user()->id,
                'username'                   => Auth::user()->username,
                'nama_lengkap'               => Auth::user()->nama_lengkap,
                'nim'                        => Auth::user()->nim,
                'nama_balita'                => $request->nama_balita,
                'tanggal_lahir'              => Carbon::parse($request->tanggal_lahir)->format('Y-m-d'),
                'tanggal_pemeriksaan'        => Carbon::now()->format('Y-m-d'),
                'nama_ibu'                   => $request->nama_ibu,
                'alamat'                     => $request->alamat,
                'usia_dalam_bulan'           => $request->usia_dalam_bulan,
                'jenis_kelamin'              => $request->jenis_kelamin,
                'berat'                      => $request->berat,
                'panjang'                    => $request->panjang,
                'rentang_usia'               => (new BalitaService)->getRentangBulan($request->tanggal_lahir),
                "kode_pertumbuhan"           => $request->kode_pertumbuhan,
                "kode_rekomendasi"           => $request->kode_rekomendasi,
                "kode_tindakan_perkembangan" => $request->kode_tindakan_perkembangan,
                "jadwal_pertumbuhan"         => $jadwal_pertumbuhan,
                "jadwal_perkembangan"        => Carbon::parse((new PerkembanganService)->getJadwalPerkembangan($request->tanggal_lahir))->format('Y-m-d'),
                "jawaban_array"              => $request->jawaban_array,
            ]);
            return response()->json([
                "success" => true,
                "message" => "Berhasil Mengirim jawaban"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => "Gagal Mengirim jawaban". $th
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

        $balita = new BalitaService();
        $jawaban_detail = Jawaban::find($id);

        if($jawaban_detail){
            $usia_bayi = $balita->getRentangBulan(Carbon::parse($jawaban_detail->tanggal_lahir_origin)->format('d-m-Y'));
    
        $perkembangan = Perkembangan::whereRelation('usia_bayi', 'rentang', '=', $usia_bayi)
        ->select(['text', 'gambar'])
        ->get();

        $array = json_decode($jawaban_detail->jawaban_array, TRUE);

        // dd($usia_bayi);
        // dd($jawaban_detail);
        // dd($jawaban_detail->jawaban_array);
        // dd($array);
        // dd($perkembangan->toArray());
    
        $perkembangan->each(function($item, $key) use ($array) { 
            $item['jawaban'] = $array[$key];
        })->all();


        if($balita->getSelisihBulan($jawaban_detail->tanggal_lahir)<3){
             $tindakan ="<span style='color:red'>Ulangi penilaian saat anak berumur tepat 3 bulan</span>";
        }else{
            $tindakan = Tindakan::getTindakan($jawaban_detail->kode_tindakan_perkembangan);
        }
       

        $response = [
            'success' => true,
            'message' => 'jawaban penilaian user',
            'data'    => [
                'pemeriksa' => [ 
                    'nim'                 => $jawaban_detail->nim,
                    'username'            => $jawaban_detail->username,
                    'nama_lengkap'        => $jawaban_detail->nama_lengkap,
                    'tanggal_pemeriksaan' => $jawaban_detail->tanggal_pemeriksaan
                ],
                'balita' => [
                    'nama'          => $jawaban_detail->nama_balita,
                    'panjang'       => $jawaban_detail->panjang ." cm",
                    'berat'         => $jawaban_detail->berat. " kg",
                    'usia'          => (new BalitaService())->getSelisihBulan($jawaban_detail->tanggal_lahir)." bulan ".$balita->getUsiaBayiTerbilang($jawaban_detail->tanggal_lahir),
                    'jenis_kelamin' => $jawaban_detail->jenis_kelamin,
                    'nama_ibu'      => $jawaban_detail->nama_ibu,
                    'alamat'        => $jawaban_detail->alamat,
                    'tanggal_lahir' => $jawaban_detail->tanggal_lahir,
                ],
                'pertumbuhan' => [
                    "kode_pertumbuhan"   => $jawaban_detail->kode_pertumbuhan,
                    "status_pertumbuhan" => Pertumbuhan::getStatusPertumbuhan($jawaban_detail->kode_pertumbuhan),
                    "kode_rekomendasi"   => $jawaban_detail->kode_rekomendasi,
                    "status_rekomendasi" => Rekomendasi::getStatusRekomendasi($jawaban_detail->kode_rekomendasi)
                ],
                'perkembangan' => [
                    "hasil"               => HasilPerkembangan::getHasilPerkembangan($jawaban_detail->kode_tindakan_perkembangan),
                    "tindakan"            =>  $tindakan,
                    "jadwal_pertumbuhan"  => Tanggal::formatIndo(Carbon::parse($jawaban_detail->jadwal_pertumbuhan)->format('d-m-Y')),
                    "jadwal_perkembangan" => Tanggal::formatIndo(Carbon::parse($jawaban_detail->jadwal_perkembangan)->format('d-m-Y'))
                ],
                'jawaban' => $perkembangan 
            ]  
        ];

        return response()->json($response);
        }
        else{
            return response()->json([ 
            'success' => false,
            'message' => 'jawaban dengan id = '.$id.' tidak ditemukan']);
        }
   
      
    }
}