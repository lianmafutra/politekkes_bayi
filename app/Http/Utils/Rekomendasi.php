<?php

namespace App\Http\Utils;


abstract class Rekomendasi  
{
    const TIDAK_NORMAL = '<p style="text-align: justify;"><strong>Maka perlu dikonfirmasi oleh petugas kesehatan yang berkompeten untuk dilakukan: penilaian status gizi berdasarkan indeks BB/U, PB/U atau TB/U, BB/PB dan atau BB/TB, IMT/U</strong></p> Tekan selanjutnya untuk melakukan penilaian perkembangan balita';
    const NORMAL = '<p style="text-align: justify;"><strong>Maka perlu dilihat tren pertumbuhannya, Bila tren mengikuti garis pertumbuhan (Naik), maka anak dapat kembali ke Posyandu untuk dipantau pertumbuhannya pada bulan berikutnya.</strong></p> Tekan selanjutnya untuk melakukan penilaian perkembangan balita';

    
    const TIDAK_NORMAL_JAWABAN = '<p style="text-align: justify;"><strong>Maka perlu dikonfirmasi oleh petugas kesehatan yang berkompeten untuk dilakukan: penilaian status gizi berdasarkan indeks BB/U, PB/U atau TB/U, BB/PB dan atau BB/TB, IMT/U</strong></p> Tekan selanjutnya untuk melakukan penilaian perkembangan balita';
    const NORMAL_JAWABAN = '<p style="text-align: justify;"><strong>Maka perlu dilihat tren pertumbuhannya, Bila tren mengikuti garis pertumbuhan (Naik), maka anak dapat kembali ke Posyandu untuk dipantau pertumbuhannya pada bulan berikutnya.</strong></p> Tekan selanjutnya untuk melakukan penilaian perkembangan balita';


    public static function getStatusRekomendasi($kode_rekomendasi){
        if($kode_rekomendasi=='normal'){
            return Rekomendasi::NORMAL_JAWABAN;
        }else if($kode_rekomendasi=='tidak_normal'){
            return Rekomendasi::TIDAK_NORMAL_JAWABAN;
        }
        else{
            return "kode rekomendasi error";
        }
    }

}
