<?php

namespace App\Http\Services;
use App\Http\Utils\HasilPerkembangan;
use App\Http\Utils\Tindakan;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\PenilaianTraits;
use App\Http\Utils\Pertumbuhan;
use App\Http\Utils\Rekomendasi;
use App\Models\Jawaban;
use App\Models\Perkembangan;

class PerkembanganService  
{

    public static function getHasilPerkembangan($tgl_lahir, $array_jawaban){

        $hasil_perkembangan="";
        $tindakan="";
        $kode_tindakan="";
        $jumlah_ya = count(array_keys($array_jawaban, "ya"));
        
       if($jumlah_ya >= 9){
            $hasil_perkembangan=HasilPerkembangan::SESUAI;
            $tindakan=Tindakan::SESUAI;
            $kode_tindakan="sesuai";
        }
        else if($jumlah_ya >= 7){
            $hasil_perkembangan=HasilPerkembangan::MERAGUKAN;
            $tindakan=Tindakan::MERAGUKAN;
            $kode_tindakan="meragukan";
        }else if($jumlah_ya <= 6){
            $hasil_perkembangan=HasilPerkembangan::PENYIMPANGAN;
            $tindakan=Tindakan::PENYIMPANGAN;
            $kode_tindakan="penyimpangan";
        }

        //hitung jadwal perkembangan berikutnya
        
        //3-24 (rentang 3 bulan )
        //24-60 (rentang 6 bulan )

        //1 rentang 0-3
        // 3-1 = 2 bulan berikutnya 
        
        //5 rentang 3-6
        //6-5= 1 

        //6 rentang 6-9
        //9-6 = 3 

        return response()->json([
            "success" => true,
            "message" => "hasil perkembangan ",
            "data"    => [
                "hasil_perkembangan"         => '<strong>'.$hasil_perkembangan . "</strong> ,<br><br> tekan selanjutnya untuk melihat hasil rekomendasi",
                "kode_tindakan_perkembangan" => $kode_tindakan,
                "tindakan"                   => $tindakan . "<br><br> Tekan selanjutnya untuk mengetahui jadwal penilaian pertumbuhan dan perkembangan berikutnya",
                "jadwal_pertumbuhan"         => "Jadwal Pertumbuhan akan dilakukan pada tanggal : ".Carbon::parse($tgl_lahir)->addMonths(1)->format('d-m-Y'),
                "jadwal_perkembangan"        => "Jadwal Perkembangan akan dilakukan ".HasilPerkembangan::HASIL_JADWAL
            ]
        ]);
    }



}