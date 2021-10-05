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
        
   
        $tgl_lahir_only_date = Carbon::parse($tgl_lahir)->format('d');
        $tgl_pemeriksaan = Carbon::now()->addMonths(1)->format('m-Y');

        $jadwal_pertumbuhan = Carbon::parse($tgl_lahir_only_date .'-'. $tgl_pemeriksaan)->format('d-m-Y'); 
         $kurang_3bulan="";
        
        
        if($balita->getSelisihBulan($tgl_lahir)<3){
            // $kurang_3bulan = "<br><span style='color:red'> Untuk balita yg umurnya kurang dari 3 bulan boleh lanjut penilaian<span>"; 
          
            //  $hasil_perkembangan = "Untuk balita yg umurnya kurang dari 3 bulan boleh lanjut penilaian";
             $tindakan ="<span style='color:red'>Ulangi penilaian saat anak berumur tepat 3 bulan</span>";
        }
        
        return response()->json([
            "success" => true,
            "message" => "hasil perkembangan ",
            "data"    => [
                "hasil_perkembangan"         => '<strong>'.$hasil_perkembangan." </strong> ,<br><br> tekan selanjutnya untuk melihat hasil rekomendasi",
                "kode_tindakan_perkembangan" => $kode_tindakan,
                "tindakan"                   => $tindakan . "<br><br> Tekan selanjutnya untuk mengetahui jadwal penilaian pertumbuhan dan perkembangan berikutnya",
                "jadwal_pertumbuhan"         => "Jadwal Pertumbuhan akan dilakukan pada tanggal : ".'<strong>'.Tanggal::formatIndo( $jadwal_pertumbuhan).'</strong>',
            //   "tgl"=> $this->getJadwalPerkembangan($tgl_lahir),
                 "jadwal_perkembangan"        => "Jadwal Perkembangan akan dilakukan pada tanggal : ".'<strong>'.Tanggal::formatIndo($this->getJadwalPerkembangan($tgl_lahir)).'</strong>',
            ]
        ]);
    }

    public function getJadwalPerkembangan($tgl_lahir){
        //hitung jadwal perkembangan berikutnya
        //rumus = rentang_akhir - usia bayi dalam bulan
        $balita = new BalitaService();
        $usia_dalam_bulan =   $balita->getSelisihBulan($tgl_lahir);
        $tgl_pemeriksaan = Carbon::now();
        $rentang =  $balita->getRentangBulan($tgl_lahir);  
        $rentang_akhir = substr($rentang, strrpos($rentang, '-' )+1);
        $bulan_berikutnya = $rentang_akhir-$usia_dalam_bulan;
        $jadwal_perkembangan = $tgl_pemeriksaan->addMonths($bulan_berikutnya)->format('d-m-Y');
        //  $rumus = 'tgl_lahir = '.$tgl_lahir.', usia = '.$usia_dalam_bulan.' bulan, rentang = '. $rentang. ', maka = '.$rentang_akhir.'-'.$usia_dalam_bulan.'= '.$bulan_berikutnya.' bulan, '.        $jadwal_perkembangan;
         return $jadwal_perkembangan;
   
    } 



}