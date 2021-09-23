<?php

namespace App\Http\Services;
use App\Http\Utils\HasilPerkembangan;
use App\Http\Utils\Tindakan;
use Carbon\Carbon;


class PerkembanganService  
{

    public static function getHasilPerkembangan($tgl_lahir, $array_jawaban=[]){


        $hasil_perkembangan="";
        $tindakan="";
        $kode_tindakan="";

        if(count($array_jawaban)<=6){
            $hasil_perkembangan=HasilPerkembangan::PENYIMPANGAN;
            $tindakan=Tindakan::PENYIMPANGAN;
            $kode_tindakan="penyimpangan";
        } else if(count($array_jawaban)>=7){
            $hasil_perkembangan=HasilPerkembangan::MERAGUKAN;
            $tindakan=Tindakan::MERAGUKAN;
            $kode_tindakan="meragukan";
        }else if(count($array_jawaban)>=9){
            $hasil_perkembangan=HasilPerkembangan::SESUAI;
            $tindakan=Tindakan::SESUAI;
            $kode_tindakan="sesuai";
        }
       
        return response()->json([
            "success" => true,
            "message" => "hasil perkembangan ",
            "data"    => [
                "hasil_perkembangan"         => $hasil_perkembangan,
                "kode_tindakan_perkembangan" => $kode_tindakan,
                "tindakan"                   => $tindakan,
                "jadwal_pertumbuhan"         => Carbon::parse($tgl_lahir)->addMonths(1)->format('d-m-Y'),
                "jadwal_perkembangan"        => HasilPerkembangan::HASIL_JADWAL
            ]
        ]);
    }

}