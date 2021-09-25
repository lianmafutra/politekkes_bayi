<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\JawabanService;
use Illuminate\Http\Request;
class JawabanController extends Controller
{
   

    public function kirimJawaban(JawabanService $jawabanService, Request $request){
       return $jawabanService->kirimJawaban($request);
    }

    public function getHistoriJawabanByUser(){
      return JawabanService::getHistoriJawabanByUser();
    }

    public function getHistoriJawabanByAdmin(){
        return JawabanService::getHistoriJawabanByAdmin();
    }

    public function getHistoriJawabanDetail(JawabanService $jawabanService, $id){
        return $jawabanService->getHistoriJawabanDetail($id);
    }
}


