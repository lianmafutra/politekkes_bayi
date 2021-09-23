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

    public static function getHasilPerkembangan(){
        
    }

}

