<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perkembangan extends Model
{
    use HasFactory;
    protected $table = 'perkembangan';

    public function usia_bayi()
    {
        return $this->belongsTo(UsiaBayi::class);
    }

    public function getGambarAttribute()
    {
        if(!$this->attributes['gambar'] ==""){
            return "https://".$this->attributes['gambar'];
        }      
    }
}
