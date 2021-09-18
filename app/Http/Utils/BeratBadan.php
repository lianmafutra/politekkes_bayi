<?php

namespace App\Http\Utils;


abstract class BeratBadan  
{
    const SANGAT_KURANG = "( <-3SD ) Pertumbuhan Berat badan sangat kurang";
    const KURANG        = "( -3SD - <-2SD ) Pertumbuhan Berat badan kurang";
    const NORMAL        = "( -2SD - +1SD ) Pertumbuhan Berat badan normal";
    const LEBIH         = "( > +1SD ) Risiko Pertumbuhan Berat badan lebih";

}
