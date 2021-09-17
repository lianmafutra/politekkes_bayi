<?php

namespace App\Http\Traits;

use App\Http\Utils\BeratBadan;
use App\Http\Utils\Rekomendasi;
use App\Models\StandarBB;

trait RumusPertumbuhanTraits {

    //Penilaian pertumbuhan bayi 0-60 bulan laki-laki, perempuan

    //kolom yang dihitung 
    // -3 SD,  -2 SD,  +1 SD
    
    public function getRekomendasi($berat_badan){
        if($berat_badan == BeratBadan::NORMAL){
            return Rekomendasi::NORMAL;
        }
        else{
            return Rekomendasi::TIDAK_NORMAL;
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