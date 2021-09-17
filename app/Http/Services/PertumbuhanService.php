<?php

namespace App\Http\Services;

use App\Http\Traits\RumusPertumbuhanTraits;
use PhpParser\Builder;

class PertumbuhanService  
{
    
    private $pertumbuhan;
    private $jenis_kelamin, $berat_badan, $usia_dalam_bulan;

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

    public function jenis_kelamin($jenis_kelamin)
    {
        $this->pertumbuhan->jenis_kelamin = $jenis_kelamin;
        $this->jenis_kelamin              = $jenis_kelamin;
        return $this;
    }

    public function berat_badan($berat_badan)
    {
        $this->pertumbuhan->berat_badan = $berat_badan;
        $this->berat_badan              = $berat_badan;
        return $this;
    }

    public function hitungPertumbuhan(){
        $hasil_pertumbuhan = $this->getPertumbuhan($this->jenis_kelamin, $this->usia_dalam_bulan, $this->berat_badan);
        $this->pertumbuhan->status_pertumbuhan = $hasil_pertumbuhan;
        $this->pertumbuhan->rekomendasi        = $this->getRekomendasi($hasil_pertumbuhan);
        return $this;
    }


    public function get()
    {
        return $this->pertumbuhan;
    }
    
}
