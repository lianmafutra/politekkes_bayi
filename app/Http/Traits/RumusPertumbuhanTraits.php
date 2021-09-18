<?php

namespace App\Http\Traits;

use App\Http\Utils\BeratBadan;
use App\Http\Utils\Rekomendasi;
use App\Models\StandarBB;
use Illuminate\Database\Eloquent\Collection;

trait RumusPertumbuhanTraits {
 
    public function getRekomendasi($hasil_pertumbuhan){
        if($hasil_pertumbuhan == BeratBadan::NORMAL){
            return new Collection([ 'kode' => 'normal', 'hasil' => Rekomendasi::NORMAL]);
        }
        else{
            return new Collection([ 'kode' => 'tidak_normal', 'hasil' => Rekomendasi::TIDAK_NORMAL]);
        }
    }

    public function getPertumbuhan($jenis_kelamin, $usia_dalam_bulan, $berat_badan){

        //Penilaian pertumbuhan bayi 0-60 bulan laki-laki, perempuan

        //kolom yang dihitung hanya
        // -3 SD,  -2 SD,  +1 SD

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