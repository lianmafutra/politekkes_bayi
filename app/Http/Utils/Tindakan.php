<?php

namespace App\Http\Utils;


abstract class Tindakan  
{
    const SESUAI = '<ol style="list-style-type: upper-alpha;">
    <li><strong>Beri pujian kepada ibu karena telah mengasuh anaknya dengan baik</strong></li>
    <li><strong> Teruskan pola asuh anak sesuai dengan tahap perkembangan anak</strong></li>
    <li><strong> Beri stimulasi perkembangan anak setiap saat, sesering mungkin, sesuai dengan umur dan kesiapan&nbsp;</strong><strong>anak.</strong></li>
    <li><strong>lkutkan anak pada kegiatan penimbangan dan pelayanan kesehatan di posyandu secara teratur&nbsp;</strong><strong>sebulan 1 kali dan setiap ada kegiatan Bina Keluarga Balita (BKB). Jika anak sudah memasuki usia&nbsp;</strong><strong>prasekolah (36-72 bulan), anak dapat diikutkan pada kegiatan di Pusat Pendidikan Anak Usia Dini&nbsp;</strong><strong>(PAUD), Kelompok Bermain dan Taman Kanak-kanak.</strong></li>
    <li><strong>Lakukan pemeriksaan/skrining rutin menggunakan KPSP setiap 3 bulan pada anak berumur kurang&nbsp;</strong><strong>dari 24 bulan dan setiap 6 bulan pada anak umur 24 sampai 72 buIan</strong>.</li>
    </ol>';

    const MERAGUKAN = '<ol style="list-style-type: upper-alpha;"><li><p style="text-align: left;">
    <strong>Beri petunjuk pada ibu agar melakukan stimulasi perkembangan pada anak lebih sering lagi, 
    setiap&nbsp;</strong><strong>saat dan sesering mungkin</strong></p></li><li><p style="text-align: left;">
    <strong>Ajarkan ibu cara melakukan intervensi stimulasi perkembangan anak untuk mengatasi&nbsp;penyimpangan/mengejar 
    ketertinggalannya.</strong> </p></li><li><p><strong>Lakukan pemeriksaan kesehatan untuk mencari kemungkinan adanya 
    penyakit yang menyebabkan&nbsp;</strong><strong>penyimpangan perkembangannya dan lakukan pengobatan</strong></p></li><li>
    <p><strong>Lakukan penilaian ulang KPSP 2 minggu kemudian dengan menggunakan 
    daftar KPSP yang sesuai&nbsp;</strong><strong>dengan umur anak.</strong></p></li><li><p><strong>Jika hasil KPSP ulang 
    jawaban "ya" tetap 7 atau 8 maka kemungkinan ada penyimpangan (P)</strong></p></li></ol>';

    const PENYIMPANGAN = '<p><strong>Merujuk ke Rumah&nbsp;Sakit dengan menuliskan jenis dan jumlah penyimpangan perkembangan 
    (gerak kasar, gerak halus,&nbsp;bicara &amp; bahasa, sosialisasi dan kemandirian).</strong></p>';


    public static function getTindakan($kode_tindakan_perkembangan){
        if($kode_tindakan_perkembangan=='sesuai'){
            return Tindakan::SESUAI;
        }else if($kode_tindakan_perkembangan=='meragukan'){
            return Tindakan::MERAGUKAN;
        }else if($kode_tindakan_perkembangan=='penyimpangan'){
            return Tindakan::PENYIMPANGAN;
        }else{
            return "kode_tindakan_perkembangan error";
        }
    }


}

