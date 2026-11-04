<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spot extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'row',
        'index'
    ];

    public function parking()
    {
        return $this->hasOne(Parking::class, 'spots_id')->whereNull('horario_saida');
    }
}
