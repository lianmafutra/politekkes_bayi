<?php

namespace App\Http\Utils;


abstract class HasilPerkembangan  
{
    const SESUAI       = 'perkembangan anak sesuai dengan tahap perkembangannya (S)';
    const MERAGUKAN    = 'Perkembangan anak meragukan (M)';
    const PENYIMPANGAN = 'kemungkinan ada penyimpangan (P)';

    const HASIL_JADWAL = "<ul>
    <li><strong>Untuk anak usia kurang dai 24 bulan: tiap 3 bulan secara periodic</strong></li>
    <li><strong>Untuk anak usia diatas 3 bulan: tiap 6 bulan secara periodic</strong></li>
    </ul>";

    public static function getHasilPerkembangan($kode_tindakan_perkembangan){
        if($kode_tindakan_perkembangan=='sesuai'){
            return HasilPerkembangan::SESUAI;
        }else if($kode_tindakan_perkembangan=='meragukan'){
            return HasilPerkembangan::MERAGUKAN;
        }else if($kode_tindakan_perkembangan=='penyimpangan'){
            return HasilPerkembangan::PENYIMPANGAN;
        }else{
            return 'kode_tindakan_perkembangan tidak sesuai';
        }
    }

}

