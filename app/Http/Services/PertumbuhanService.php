<?php

namespace App\Http\Services;

use App\Http\Traits\RumusPertumbuhanTraits;
use PhpParser\Builder;
use Throwable;

class PertumbuhanService  
{
   
    private $hasil, $hasil_rekomendasi;
    protected $jenis_kelamin;
    protected $berat_badan;
    protected $usia_dalam_bulan;

    use RumusPertumbuhanTraits;


    public function __construct()
    {
        $this->pertumbuhan = new \stdClass;
    }

    public function setUsia(int $usia)
    {
        $this->pertumbuhan->usia_dalam_bulan = $usia;
        $this->usia_dalam_bulan              = $usia;
        return $this;
    }

    public function setJenisKelamin($jenis_kelamin){
        $this->pertumbuhan->jenis_kelamin = $jenis_kelamin;
        $this->jenis_kelamin              = $jenis_kelamin;
        return $this;
    }

    public function setBeratBadan(float $berat_badan){
        $this->pertumbuhan->berat_badan = $berat_badan;
        $this->berat_badan              = $berat_badan;
        return $this;
    }


    public function getHasilPertumbuhan()
    {
        //$hasil_pertumbuhan -> menghitung berat ideal dicocokkan dengan tabel pertumbuhan 

        $hasil_pertumbuhan = $this->getPertumbuhan($this->jenis_kelamin, $this->usia_dalam_bulan, $this->berat_badan);
        $this->hasil = $hasil_pertumbuhan->get('hasil');
        $this->pertumbuhan->pertumbuhan_kode =  $hasil_pertumbuhan->get('kode');
        $this->pertumbuhan->status_pertumbuhan = 'Berat balita '.$this->berat_badan.' Kg dengan ambang batas '.$hasil_pertumbuhan->get('hasil').',<br><br>Tekan selanjutnya untuk melihat rekomendasi pertumbuhan balita';
        return $this;
    }

    public function getHasilRekomendasi(){
     
        // $hasil_rekomendasi -> ketika $hasil_pertumbuhan diketahui maka ada 2 kesimpulan rekomendasi normal/tidak normal
      
        $hasil_rekomendasi = $this->getRekomendasi($this->hasil);
        $this->pertumbuhan->rekomendasi_kode   = $hasil_rekomendasi->get('kode');
        $this->pertumbuhan->rekomendasi        = $hasil_rekomendasi->get('hasil');
        return $this;
    }

    public function build(){
        return $this->pertumbuhan;
    }
  
    
}
