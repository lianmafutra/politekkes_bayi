<?php
namespace App\Http\Controllers\API;

use App\Http\Traits\PenilaianTraits;
use App\Models\Penilaian;
use App\Http\Controllers\Controller as Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DateTime;

class PenilaianController extends Controller
{

    use PenilaianTraits;

    public function getPenilaian($tanggal_lahir)
    {

        if (date('d-m-Y', strtotime($tanggal_lahir)) == $tanggal_lahir)
        {

            $usia_bayi = $this->getRentangBulan($tanggal_lahir);

            // $penilaian = cache()->rememberForever('penilaian', function () use ($umur_bayi)
            // {
            //     return Penilaian::whereRelation('umur_bayi', 'rentang', '=', $umur_bayi)
            //         ->select(['text'])
            //         ->get();
            // });

            $penilaian = Penilaian::whereRelation('usia_bayi', 'rentang', '=', $usia_bayi)
                    ->select(['text'])
                    ->get();

            return response()->json([
                'success'             => true,
                'message'             => 'rentang umur bayi ' . $this->getRentangBulan($tanggal_lahir) . ' bulan',
                'bayi'                 => [
                    'umur_dalam_hari'  => $this->getSelisihHari($tanggal_lahir),
                    'umur_dalam_bulan' => $this->getSelisihBulan($tanggal_lahir),
                    // 'umur_terbilang'   => $this->getumurBayiTerbilang($tanggal_lahir),
                    'rentang_umur'     => $this->getRentangBulan($tanggal_lahir),
                ],
                'data'                => $penilaian,
            ], 200);

        }
        else
        {
            return $this->error("format tanggal tidak sesuai", 400);
        }

    }

  

}

