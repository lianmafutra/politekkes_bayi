<?php

namespace App\Http\Utils;


abstract class Rekomendasi  
{

    const REKOMENDASI_1 = "Anak dengan kriteria nilai Zscore BB/U di bawah minus dua standar deviasi atau di atas satu standar deviasi (<-2 SD atau >+1 SD) maka perlu dikonfirmasi oleh petugas kesehatan yang berkompeten untuk dilakukan:  penilaian status gizi berdasarkan indeks BB/U, PB/U atau TB/U, BB/PB dan atau BB/TB, IMT/U ";
    const REKOMENDASI_2 = "Anak dengan kriteria nilai Z-score BB/U di antara minus dua standar deviasi sampai dengan kurang dari sama dengan satu standar deviasi ( -2 ≤ BB/U ≤ +1) termasuk anak yang normal, 
                           Perlu dilihat tren pertumbuhannya, Bila tren mengikuti garis pertumbuhan (Naik), maka anak dapat kembali ke Posyandu untuk dipantau pertumbuhannya pada bulan berikutnya";
  
}
