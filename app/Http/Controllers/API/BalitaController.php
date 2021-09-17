<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

            $usia_bayi = $this->getRentangBulan($tanggal_lahir);
            // cache()->forget('penilaian');
            $penilaian = cache()->rememberForever('penilaian', function () use ($usia_bayi)
            {
                return Penilaian::whereRelation('usia_bayi', 'rentang', '=', $usia_bayi)
                    ->select(['text'])
                    ->get();
            });

            return response()->json([
                'success'             => true,
                'message'             => 'rentang usia bayi ' . $this->getRentangBulan($tanggal_lahir) . ' bulan',
                'balita'                 => [
  
                    'usia_dalam_hari'      => $this->getSelisihHari($tanggal_lahir),
                    'usia_dalam_bulan'     => $this->getSelisihBulan($tanggal_lahir),
                    'usia_terbilang' => $this->getUsiaBayiTerbilang($tanggal_lahir),
                    'rentang_usia'   => $this->getRentangBulan($tanggal_lahir),
                ],
            ], 200);

        }
        else
        {
            return $this->error("format tanggal tidak sesuai", 400);
        }

    }

    public function getPertumbuhan(Request $request){

        $pertumbuhan = (new PertumbuhanService)
            ->usia_dalam_bulan($request->usia_dalam_bulan)
            ->jenis_kelamin($request->jenis_kelamin)
            ->berat_badan($request->berat_badan)
            ->hitungPertumbuhan()
            ->get();
        
       
            return $this->success($pertumbuhan,'pertumbuhan balita');
    }
    
}
