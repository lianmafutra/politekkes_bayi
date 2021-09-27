<?php

namespace App\Http\Utils;


abstract class BeratBadan  
{
    const SANGAT_KURANG = "<strong>( <-3SD ) Pertumbuhan Berat badan sangat kurang</strong>";
    const KURANG        = "<strong>( -3SD - <-2SD ) Pertumbuhan Berat badan kurang</strong>";
    const NORMAL        = "<strong>( -2SD - +1SD ) Pertumbuhan Berat badan normal</strong>";
    const LEBIH         = "<strong>( > +1SD ) Risiko Pertumbuhan Berat badan lebih</strong>";

}
