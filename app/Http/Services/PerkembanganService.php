<?php

namespace App\Http\Services;
use App\Http\Utils\HasilPerkembangan;
use App\Http\Utils\Tindakan;
use Carbon\Carbon;


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
       
        return response()->json([
            "success" => true,
            "message" => "hasil perkembangan ",
            "data"    => [
                "hasil_perkembangan"         => '<strong>'.$hasil_perkembangan . "</strong> ,<br><br> tekan selanjutnya untuk melihat hasil rekomendasi",
                "kode_tindakan_perkembangan" => $kode_tindakan,
                "tindakan"                   => $tindakan . "<br><br> Tekan selanjutnya untuk mengetahui jadwal penilaian pertumbuhan dan perkembangan berikutnya",
                "jadwal_pertumbuhan"         => Carbon::parse($tgl_lahir)->addMonths(1)->format('d-m-Y'),
                "jadwal_perkembangan"        => HasilPerkembangan::HASIL_JADWAL
            ]
        ]);
    }

}