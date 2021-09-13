<?php

namespace App\Http\Traits;

use Illuminate\Support\Carbon;

trait PenilaianTraits {

    public function getSelisihBulan($tanggal_lahir){
        $tanggal_sekarang = Carbon::now()->format('d-m-Y');
        $tanggal_lahir=Carbon::parse($tanggal_lahir);
        $tanggal_sekarang=Carbon::parse($tanggal_sekarang);
        $date_diff=$tanggal_lahir->diffInMonths($tanggal_sekarang);
        return $date_diff;
    }

    public function getRentangBulan($tanggal_lahir){
       $selisih_bulan =  $this->getSelisihBulan($tanggal_lahir);

       if($selisih_bulan >=0 && $selisih_bulan <3){
            return '0-3';
       } 
       elseif($selisih_bulan >=3 && $selisih_bulan <=6){
            return '3-6';
       }
       elseif($selisih_bulan >=6 && $selisih_bulan <=9){
            return '6-9';
       }
       elseif($selisih_bulan >=9 && $selisih_bulan <=12){
        return '9-12';
       }
       elseif($selisih_bulan >=12 && $selisih_bulan <=18){
            return '12-18';
        }
        elseif($selisih_bulan >=18 && $selisih_bulan <=24){
            return '18-24';
        }
        elseif($selisih_bulan >=24 && $selisih_bulan <=30){
            return '24-30';
        }
        elseif($selisih_bulan >=30 && $selisih_bulan <=36){
            return '30-36';
        }
        elseif($selisih_bulan >=36 && $selisih_bulan <=42){
            return '36-42';
        }
        elseif($selisih_bulan >=42 && $selisih_bulan <=48){
            return '42-48';
        }
        elseif($selisih_bulan >=48 && $selisih_bulan <=54){
            return '48-54';
        }
        elseif($selisih_bulan >=54 && $selisih_bulan <=60){
            return '54-60';
        }
        else{
            return 'max umur bayi 54-60 bulan';
        }
   
    }
   
}