<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PertumbuhanRequest;
use App\Http\Services\PertumbuhanService;
use Illuminate\Http\Request;

use App\Http\Traits\PenilaianTraits;
use App\Models\Penilaian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DateTime;

class BalitaController extends Controller
{

    use PenilaianTraits;

    public function getUmurBalita($tanggal_lahir){
        if (date('d-m-Y', strtotime($tanggal_lahir)) == $tanggal_lahir)
        {
            $data = [
                'balita'  => [
                    'usia_dalam_hari'  => $this->getSelisihHari($tanggal_lahir),
                    'usia_dalam_bulan' => $this->getSelisihBulan($tanggal_lahir),
                    'usia_terbilang'   => 'Umur balita pada saat ini <strong>'.$this->getUsiaBayiTerbilang($tanggal_lahir).'</strong>, Tekan selanjutnya untuk melakukan penilaiaan pertumbuhan balita',
                    'rentang_usia'     => $this->getRentangBulan($tanggal_lahir),
                ]
            ];

            return $this->success( $data,'rentang usia bayi '.$this->getRentangBulan($tanggal_lahir) . ' bulan');
        }
        else
        {
            return $this->error("format tanggal tidak sesuai", 400);
        }

    }

    public function getPertumbuhan(PertumbuhanRequest $request){

        $validated = $request->validated();

        if($validated){
            $pertumbuhan = (new PertumbuhanService)
            ->usia_dalam_bulan($request->usia_dalam_bulan)
            ->jenis_kelamin($request->jenis_kelamin)
            ->berat_badan($request->berat_badan)
            ->hitungPertumbuhan()
            ->get();
        
            return $this->success($pertumbuhan,'hasil perhitungan pertumbuhan balita');
        }
      
    }
    
}
