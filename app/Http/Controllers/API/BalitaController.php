<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PertumbuhanRequest;
use App\Http\Services\BalitaService;
use App\Http\Services\PertumbuhanService;



class BalitaController extends Controller
{



    public function getUmurBalita($tanggal_lahir)
    {
        $balita = new BalitaService();
        if (date('d-m-Y', strtotime($tanggal_lahir)) == $tanggal_lahir)
        {
            if($balita->getSelisihBulan($tanggal_lahir)<60){
               
                $data = [
                    'balita'  => [
                        'usia_balita'      => $balita->getUsiaBayiTerbilang($tanggal_lahir),
                        'usia_dalam_hari'  => $balita->getSelisihHari($tanggal_lahir),
                        'usia_dalam_bulan' => $balita->getSelisihBulan($tanggal_lahir),
                        'rentang_usia'     => $balita->getRentangBulan($tanggal_lahir),
                        'usia_terbilang'   => 'Umur balita pada saat ini <strong>'.$balita->getUsiaBayiTerbilang($tanggal_lahir).'</strong>, Tekan selanjutnya untuk melakukan penilaiaan pertumbuhan balita',
                    ]
                ];
    
                return $this->success( $data,'rentang usia bayi '.$balita->getRentangBulan($tanggal_lahir) . ' bulan');
           
            }
            else{
                return $this->error("maaf umur lebih dari 60 bulan", 200);
            }
        }
        else
        {
            return $this->error("format tanggal tidak sesuai", 200);
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
