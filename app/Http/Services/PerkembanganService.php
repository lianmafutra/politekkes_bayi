<?php

namespace App\Http\Services;
use App\Http\Utils\HasilPerkembangan;
use App\Http\Utils\Tindakan;
use Carbon\Carbon;


class PerkembanganService  
{


    public function getHasilPerkembangan($tgl_lahir, $array_jawaban){
        $balita = new BalitaService();
        $hasil_perkembangan="";
        $tindakan="";
        $kode_tindakan="";
        $jumlah_ya = count(array_keys($array_jawaban, "ya"));
        
       if($jumlah_ya >= 9){
            $hasil_perkembangan=HasilPerkembangan::SESUAI;
            $tindakan=Tindakan::SESUAI;
            $kode_tindakan="sesuai";
        }
        else if($jumlah_ya >= 7){
            $hasil_perkembangan=HasilPerkembangan::MERAGUKAN;
            $tindakan=Tindakan::MERAGUKAN;
            $kode_tindakan="meragukan";
        }else if($jumlah_ya <= 6){
            $hasil_perkembangan=HasilPerkembangan::PENYIMPANGAN;
            $tindakan=Tindakan::PENYIMPANGAN;
            $kode_tindakan="penyimpangan";
        }

      
        
        return response()->json([
            "success" => true,
            "message" => "hasil perkembangan ",
            "data"    => [
                "hasil_perkembangan"         => '<strong>'.$hasil_perkembangan . "</strong> ,<br><br> tekan selanjutnya untuk melihat hasil rekomendasi",
                "kode_tindakan_perkembangan" => $kode_tindakan,
                "tindakan"                   => $tindakan . "<br><br> Tekan selanjutnya untuk mengetahui jadwal penilaian pertumbuhan dan perkembangan berikutnya",
                "jadwal_pertumbuhan"         => "Jadwal Pertumbuhan akan dilakukan pada tanggal : ".Tanggal::formatIndo(Carbon::parse($tgl_lahir)->addMonths(1)->format('d-m-Y')),
                "jadwal_perkembangan"        => Tanggal::formatIndo($this->getJadwalPerkembangan($tgl_lahir)),
            ]
        ]);
    }

    public function getJadwalPerkembangan($tgl_lahir){
        //hitung jadwal perkembangan berikutnya
        //rumus = rentang_akhir - usia bayi dalam bulan
        $balita = new BalitaService();
        $usia_dalam_bulan =   $balita->getSelisihBulan($tgl_lahir);
        $rentang =  $balita->getRentangBulan($tgl_lahir);  
        $rentang_akhir = substr($rentang, strrpos($rentang, '-' )+1);
        $bulan_berikutnya = $rentang_akhir-$usia_dalam_bulan;
        $jadwal_perkembangan = Carbon::parse($tgl_lahir)->addMonths($bulan_berikutnya)->format('d-m-Y');
        // $rumus = 'tgl_lahir = '.$tgl_lahir.', usia = '.$usia_dalam_bulan.' bulan, rentang = '. $rentang. ', maka = '.$rentang_akhir.'-'.$usia_dalam_bulan.'= '.$bulan_berikutnya.' bulan';
        return $jadwal_perkembangan;
   
    } 



}