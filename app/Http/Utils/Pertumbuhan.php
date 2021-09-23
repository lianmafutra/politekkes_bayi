<?php

namespace App\Http\Utils;


abstract class Pertumbuhan  
{
  
    public static function getStatusPertumbuhan($kode_pertumbuhan){

        if($kode_pertumbuhan=='sangat_kurang'){
            return BeratBadan::SANGAT_KURANG;
        }else if($kode_pertumbuhan=='kurang'){
            return BeratBadan::KURANG;
        }else if($kode_pertumbuhan=='normal'){
            return BeratBadan::NORMAL;
        }else if($kode_pertumbuhan=='lebih'){
            return BeratBadan::LEBIH;
        }
        else{
            return "kode kode_pertumbuhan error";
        }
    }

}
