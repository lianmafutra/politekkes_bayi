<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PertumbuhanRequest;
use App\Http\Services\PertumbuhanService;
use App\Http\Traits\PenilaianTraits;


class BalitaController extends Controller
{

    use PenilaianTraits;

    public function getUmurBalita($tanggal_lahir)
    {
        if (date('d-m-Y', strtotime($tanggal_lahir)) == $tanggal_lahir)
        {
            $data = [
                'balita'  => [
                    'usia_balita'  => $this->getUsiaBayiTerbilang($tanggal_lahir),
                    'usia_dalam_hari'  => $this->getSelisihHari($tanggal_lahir),
                    'usia_dalam_bulan' => $this->getSelisihBulan($tanggal_lahir),
                    'rentang_usia'     => $this->getRentangBulan($tanggal_lahir),
                    'usia_terbilang'   => 'Umur balita pada saat ini <strong>'.$this->getUsiaBayiTerbilang($tanggal_lahir).'</strong>, Tekan selanjutnya untuk melakukan penilaiaan pertumbuhan balita',
                ]
            ];

            return $this->success( $data,'rentang usia bayi '.$this->getRentangBulan($tanggal_lahir) . ' bulan');
        }
        else
        {
            return $this->error("format tanggal tidak sesuai", 400);
        }

    }

    public function getPertumbuhan(PertumbuhanRequest $request)
    {
        $validated = $request->validated();
        if($validated){
            $pertumbuhan = (new PertumbuhanService)
                ->setUsia($request->usia_dalam_bulan)
                ->setJenisKelamin($request->jenis_kelamin)
                ->setBeratBadan($request->berat_badan)
                ->getHasilPertumbuhan()
                ->getHasilRekomendasi()
                ->build();

            return $this->success($pertumbuhan,'hasil perhitungan pertumbuhan balita');
        }
    }
    
}
