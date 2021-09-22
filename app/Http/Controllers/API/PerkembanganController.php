<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\PenilaianTraits;
use App\Models\Perkembangan;
use Illuminate\Http\Request;

class PerkembanganController extends Controller
{

    use PenilaianTraits;

    public function getPertanyaan($tanggal_lahir){

        $usia_bayi = $this->getRentangBulan($tanggal_lahir);
        $Perkembangan = Perkembangan::all();

        // dd(Perkembangan::all()->toArray());

        return response()->json([
            "success"      => true,
            "rentang_umur" => $this->getRentangBulan($tanggal_lahir),
            "usia_bulan"   => $this->getSelisihBulan($tanggal_lahir),
            "data"         => $Perkembangan
        ]
        );
    }
}
