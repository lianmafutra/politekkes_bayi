<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\PenilaianTraits;
use App\Models\Perkembangan;
use Illuminate\Http\Request;

class PerkembanganController extends Controller
{

    use PenilaianTraits;

    public function getPertanyaan(){
        $Perkembangan = Perkembangan::all();
        return response()->json([
            "success" => true,
            "usia_bulan" => $this->getSelisihBulan('20-05-2021'),
            "data"=>  $Perkembangan
        ]
           
        );
    }
}
