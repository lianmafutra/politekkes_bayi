<?php


namespace App\Http\Services;

use Carbon\Carbon;

class Tanggal  
{
   

    public static function formatIndo($tgl){
        $dt = new Carbon($tgl);
		setlocale(LC_TIME, 'IND');
		
		return $dt->formatLocalized('%d-%B-%Y');        
    }

 
}