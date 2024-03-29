<?php

namespace App\Models;

use App\Http\Services\Tanggal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;

    protected $table = 'jawaban';
    protected $guarded = [];
    protected $appends = ['tanggal_lahir_origin'];
   
    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
            ->format('d-m-Y H:i:s');
    }

    public function getUpdatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['updated_at'])
            ->format('d-m-Y H:i:s');
    }

    public function getTanggalLahirAttribute()
    {
        return Tanggal::formatIndo(\Carbon\Carbon::parse($this->attributes['tanggal_lahir'])
            ->format('d-m-Y'));
    }

    public function getTanggalLahirOriginAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['tanggal_lahir'])
            ->format('d-m-Y');
    }

    public function getTanggalPemeriksaanAttribute()
    {
        return Tanggal::formatIndo(\Carbon\Carbon::parse($this->attributes['tanggal_pemeriksaan'])
            ->format('d-m-Y'));
    }
}
