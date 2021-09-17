<?php

namespace App\Http\Traits;

use App\Http\Utils\BeratBadan;
use App\Http\Utils\Rekomendasi;
use App\Models\StandarBB;

trait RumusPertumbuhanTraits {

    
    //penilaian pertumbuhan bayi 0-60 bulan




    //kolom
    // -3 SD,  -2 SD,  +1 SD



    
    public function getRekomendasi($berat_badan){
        if($berat_badan == BeratBadan::NORMAL){
            return Rekomendasi::REKOMENDASI_2;
        }
        else{
            return Rekomendasi::REKOMENDASI_1;
        }
    }

    public function getPertumbuhan($jenis_kelamin, $usia_dalam_bulan, $berat_badan){
        $data = StandarBB::where('jenis_kelamin','=',$jenis_kelamin)->where('umur','=', $usia_dalam_bulan)->first();


        if($berat_badan < $data->m3){
            return BeratBadan::SANGAT_KURANG;
        }
        else if($berat_badan < $data->m2){
            return BeratBadan::KURANG;
        }
        else if($berat_badan <= $data->p1 ){
            return BeratBadan::NORMAL;
        }
        else if($berat_badan > $data->p1){
            return BeratBadan::LEBIH;
        }
    
     
    }

    
  



}