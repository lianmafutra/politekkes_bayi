<?php

namespace App\Http\Services;

use App\Http\Traits\RumusPertumbuhanTraits;
use PhpParser\Builder;

class PertumbuhanService  
{
    private $pertumbuhan, $jenis_kelamin, $berat_badan, $usia_dalam_bulan;

    use RumusPertumbuhanTraits;

    public function __construct()
    {
        $this->pertumbuhan = new \stdClass;
    }

    public function usia_dalam_bulan(int $usia)
    {
        $this->pertumbuhan->usia_dalam_bulan = $usia;
        $this->usia_dalam_bulan              = $usia;
        return $this;
    }

    public function jenis_kelamin($jenis_kelamin){
        $this->pertumbuhan->jenis_kelamin = $jenis_kelamin;
        $this->jenis_kelamin              = $jenis_kelamin;
        return $this;
    }

    public function berat_badan(float $berat_badan){
        $this->pertumbuhan->berat_badan = $berat_badan;
        $this->berat_badan              = $berat_badan;
        return $this;
    }

    public function hitungPertumbuhan()
    {
        /* - $hasil_pertumbuhan -> menghitung berat ideal dicocokkan dengan tabel pertumbuhan.
        - $hasil_rekomendasi -> ketika $hasil_pertumbuhan diketahui maka ada 2 kesimpulan 
                               rekomendasi normal/tidak normal */

        $hasil_pertumbuhan = $this->getPertumbuhan($this->jenis_kelamin, $this->usia_dalam_bulan, $this->berat_badan);
        $hasil_rekomendasi = $this->getRekomendasi($hasil_pertumbuhan);

        $this->pertumbuhan->status_pertumbuhan = $hasil_pertumbuhan;
        $this->pertumbuhan->rekomendasi_kode   = $hasil_rekomendasi->get('kode');
        $this->pertumbuhan->rekomendasi        = 'Berat balita '.$this->berat_badan.' Kg dengan ambang batas '.$hasil_pertumbuhan. ', '.$hasil_rekomendasi->get('hasil');
        
        return $this;
    }

    public function get()
    {
        return $this->pertumbuhan;
    }
    
}
