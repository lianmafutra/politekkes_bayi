<?php


namespace App\Http\Services;

use Carbon\Carbon;
use DateTime;

class BalitaService
{

    
    public function getSelisihBulan($tanggal_lahir){
        $tanggal_sekarang = Carbon::now()->format('d-m-Y');
        $tanggal_lahir=Carbon::parse($tanggal_lahir);
        $tanggal_sekarang=Carbon::parse($tanggal_sekarang);
        $date_diff=$tanggal_lahir->diffInMonths($tanggal_sekarang);
       
        return $date_diff;
    }
   
    public function getSelisihHari($tanggal_lahir){
        $tanggal_sekarang = Carbon::now()->format('d-m-Y');
        $tanggal_lahir=Carbon::parse($tanggal_lahir);
        $tanggal_sekarang=Carbon::parse($tanggal_sekarang);
        $date_diff=$tanggal_lahir->diffInDays($tanggal_sekarang);
        return $date_diff;
    }

    public function getUsiaBayiTerbilang($tanggal_lahir){        
        $tgl_lahir = new DateTime($tanggal_lahir);
        $today = new DateTime('today');
        $y = $today->diff($tgl_lahir)->y;
        $m = $today->diff($tgl_lahir)->m;
        $d = $today->diff($tgl_lahir)->d;
        return $y . " tahun " . $m . " bulan " . $d . " hari";
    }


    public function getRentangBulan($tanggal_lahir){
    
        $selisih_bulan =  $this->getSelisihBulan($tanggal_lahir);
 
        if($selisih_bulan >=0 && $selisih_bulan <3){
             return '0-3';
        } 
        elseif($selisih_bulan >=3 && $selisih_bulan <6){
             return '3-6';
        }
        elseif($selisih_bulan >=6 && $selisih_bulan <9){
             return '6-9';
        }
        elseif($selisih_bulan >=9 && $selisih_bulan <12){
             return '9-12';
        }
        elseif($selisih_bulan >=12 && $selisih_bulan <15){
             return '12-15';
         }
         elseif($selisih_bulan >=15 && $selisih_bulan <18){
             return '15-18';
         }
         elseif($selisih_bulan >=18 && $selisih_bulan <21){
             return '18-21';
         }
         elseif($selisih_bulan >=21 && $selisih_bulan <24){
             return '21-24';
         }
         elseif($selisih_bulan >=24 && $selisih_bulan <30){
             return '24-30';
         }
         elseif($selisih_bulan >=30 && $selisih_bulan <36){
             return '30-36';
         }
         elseif($selisih_bulan >=36 && $selisih_bulan <42){
             return '36-42';
         }
         elseif($selisih_bulan >=42 && $selisih_bulan <48){
             return '42-48';
         }
         elseif($selisih_bulan >=48 && $selisih_bulan <54){
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