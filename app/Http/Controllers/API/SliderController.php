<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;


class SliderController extends Controller
{
    public function index(){

        $sliders = array(
            array(
                "title" => "contoh slider 1",
                "url"   => "https://i.picsum.photos/id/488/400/400.jpg?hmac=WlUFPZqhy1eoQ8wRYqRVGce3D4abH7MkZZZk3uGLxYs",
            ),
            array(
                "title" => "contoh slider 2",
                "url"   => "https://i.picsum.photos/id/113/400/400.jpg?hmac=hCg1mc0JZPvlwmU2b7Lu17RjRcBxyHCdgiF1URs9PuE",
            ),
        );
        
        return $this->success($sliders,"slider beranda");
    }
}
