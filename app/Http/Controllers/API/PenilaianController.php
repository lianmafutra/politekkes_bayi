<?php

namespace App\Http\Controllers\API;

use App\Http\Traits\PenilaianTraits;
use App\Models\Penilaian;
use App\Http\Controllers\Controller as Controller;
use Carbon\Carbon;
use DateTime;


class PenilaianController extends Controller
{

    use PenilaianTraits;

    public function getPenilaian($tanggal_lahir){

   
   if(date('d-m-Y', strtotime($tanggal_lahir)) == $tanggal_lahir){
        $usia_bayi = $this->getRentangBulan($tanggal_lahir);
        

        $penilaian = Penilaian::whereRelation('usia_bayi', 'rentang', '=', $usia_bayi)->select(['text'])->get();
        
	    $response = [
            'success' => true,
            'message' => 'rentang usia bayi '. $this->getRentangBulan($tanggal_lahir). ' bulan',
            'usia_bayi' => $this->getRentangBulan($tanggal_lahir),
            'data'    =>  $penilaian,
          
        ];

        return response()->json($response, 200);
   }else{
        return $this->error("format tanggal tidak sesuai", 400);
   }
      
}


}
