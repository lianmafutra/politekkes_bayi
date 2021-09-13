<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Penilaian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class JawabanController extends Controller
{
    
    public function kirimJawaban(Request $request){

        /**
        *ambil id usia bayi untuk get query penilaian

        *hasil jawaban [ya, tidak, ya]
         */


    //Kirim data Dari mobile 
     $id_usia_bayi = '-';         // rentang usia bayi
     $array =['ya','tidak','ya']; //sesuai pilihan user
     //data bayi tinggi berat badan dll

      $penilaian = Penilaian::whereRelation('usia_bayi', 'rentang', '=', $id_usia_bayi)->select(['text'])->get(); 
      $penilaian->each(function($item, $key) use ($array) { 
            $item['jawaban'] = $array[$key];
        })->all();
      
        $response = [
            'message' => 'jawaban penilaian user',
            'data'    => [
                'user' => [ 
                    'nim' => Auth::user()->nim,
                    'username' => Auth::user()->username,
                    'tanggal_pengisian' => Carbon::now()->format('d-m-Y H:i:s')
                ],
                'bayi' => [
                    'nama' => 'Huda',
                    'panjang' => '20 cm',
                    'berat' => '2.5 kg',
                ],
                'penilaian' => $penilaian
                
            ]  
          
        ];

        return response()->json($response);
    }
}
