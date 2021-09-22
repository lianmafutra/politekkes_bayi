<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsiaBayi extends Model
{
    use HasFactory;
    protected $table = 'usia_bayi';


    public function perkembangan(){
        return $this->hasMany(Perkembangan::class);
    }
}
