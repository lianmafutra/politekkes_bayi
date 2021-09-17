<?php

namespace App\Http\Utils;


abstract class BeratBadan  
{
    const SANGAT_KURANG = "( <-3SD ) Berat badan sangat kurang";
    const KURANG        = "( -3SD - <-2SD ) Berat badan kurang";
    const NORMAL        = "( -2SD - + 1SD ) Berat badan normal";
    const LEBIH         = "( > + 1SD ) Risiko Berat badan lebih";

}
