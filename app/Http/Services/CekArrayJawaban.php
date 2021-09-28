<?php

namespace App\Http\Services;

use App\Models\Perkembangan;

class CekArrayJawaban
{
    public function invalid($request){
        $array_jawaban =  count(json_decode($request->jawaban_array, TRUE));
        $rentang_usia = (new BalitaService)->getRentangBulan($request->tanggal_lahir);
        $perkembangan = Perkembangan::whereRelation('usia_bayi', 'rentang', '=', $rentang_usia)->count();
      
        if($array_jawaban!=$perkembangan){
            return false;
        }
        else{
            return true;
        }
    }

}