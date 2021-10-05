<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\BalitaService;
use App\Http\Services\PerkembanganService;

use App\Models\Perkembangan;
use Illuminate\Http\Request;

class PerkembanganController extends Controller
{

    public function getPertanyaan($tanggal_lahir){
        $balita = new BalitaService();
        if (date('d-m-Y', strtotime($tanggal_lahir)) == $tanggal_lahir)
        {
            $usia_bayi =  $balita->getRentangBulan($tanggal_lahir);

            $Perkembangan = Perkembangan::whereRelation('usia_bayi', 'rentang', '=', $usia_bayi)
            ->select(['bulan','usia_bayi_id','text', 'gambar'])
            ->get();

            return response()->json([
                    "success"      => true,
                    "rentang_umur" =>  $balita->getRentangBulan($tanggal_lahir),
                    "usia_bulan"   =>  $balita->getSelisihBulan($tanggal_lahir),
                    "data"         => $Perkembangan
            ]);
        }
        else{
            return $this->error("format tanggal tidak sesuai", 200);
        }

    }

    public function getHasilPerkembangan(PerkembanganService $perkembanganService, Request $request){
        $array_jawaban = json_decode(request('jawaban'));
        return $perkembanganService->getHasilPerkembangan($request->tgl_lahir,$array_jawaban);
    }
}
