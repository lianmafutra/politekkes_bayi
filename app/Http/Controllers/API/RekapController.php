<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Utils\BeratBadan;
use App\Http\Utils\HasilPerkembangan;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class RekapController extends Controller
{
    public function getRekapHari(Request $request, $tgl){

 
        $jawaban = Jawaban::where('tanggal_pemeriksaan',  Carbon::parse($tgl)->format('Y-m-d'));
       
        if($request->ajax()){
            return DataTables::of( $jawaban->get())
            ->addColumn('kode_pertumbuhan', function($row){
                    if($row->kode_pertumbuhan=="normal"){
                        return BeratBadan::NORMAL;
                    }
                    if($row->kode_pertumbuhan=="sangat_kurang"){
                        return BeratBadan::SANGAT_KURANG;
                    }
                    if($row->kode_pertumbuhan=="kurang"){
                        return BeratBadan::KURANG;
                    }
                    if($row->kode_pertumbuhan=="lebih"){
                        return BeratBadan::LEBIH;
                    }
            })
            ->addColumn('kode_tindakan_perkembangan', function($row){
               return HasilPerkembangan::getHasilPerkembangan($row->kode_tindakan_perkembangan);    
        })
            ->addColumn('aksi', function($row){
                $btn = '<a href="javascript:void(0)"  data-id="'.$row->id.'" class="detail button">Detail</a>';
                 return $btn;
         })
         ->rawColumns(['aksi', 'kode_pertumbuhan','kode_tindakan_perkembangan'])
            ->addIndexColumn()
            ->make(true);
        }
      
         return view('rekap_jawaban_harian');
    }
}
