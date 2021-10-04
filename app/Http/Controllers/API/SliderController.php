<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;


class SliderController extends Controller
{
    public function index(){

        $sliders = array(
            array(
                "title" => "contoh slider 1",
                "url"   => "https://lmproject.my.id/storage/slider/1.jpg",
            ),
            array(
                "title" => "contoh slider 2",
                 "url"   => "https://lmproject.my.id/storage/slider/2.jpg",
            ),
             array(
                "title" => "contoh slider 3",
                 "url"   => "https://lmproject.my.id/storage/slider/3.jpg",
            ),
        );
        
        return $this->success($sliders,"slider beranda");
    }
}
