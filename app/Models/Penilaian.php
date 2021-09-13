<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;
    protected $table = 'penilaian';


    public function usia_bayi()
    {
        return $this->belongsTo(UsiaBayi::class);
    }
}
