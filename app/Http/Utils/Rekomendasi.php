<?php

namespace App\Http\Utils;


abstract class Rekomendasi  
{

    const TIDAK_NORMAL = '<p style="text-align: justify;">Anak dengan kriteria nilai Zscore BB/U di bawah minus dua standar deviasi atau di atas satu standar deviasi (&lt;-2 SD atau &gt;+1 SD) <strong><br><br>maka perlu dikonfirmasi oleh petugas kesehatan yang berkompeten untuk dilakukan: penilaian status gizi berdasarkan indeks BB/U, PB/U atau TB/U, BB/PB dan atau BB/TB, IMT/U</strong></p>';
    const NORMAL = '<p style="text-align: justify;">Anak dengan kriteria nilai Z-score BB/U di antara minus dua standar deviasi sampai dengan kurang dari sama dengan satu standar deviasi ( -2 &le; BB/U &le; +1) termasuk anak yang normal,&nbsp;<strong><br><br>Perlu dilihat tren pertumbuhannya, Bila tren mengikuti garis pertumbuhan (Naik), maka anak dapat kembali ke Posyandu untuk dipantau pertumbuhannya pada bulan berikutnya.</strong></p>';
  
}
