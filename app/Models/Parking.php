<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    protected $table = 'parking';

    protected $primaryKey = 'ticket';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'vehicles_id',
        'horario_entrada',
        'horario_saida',
        'preco',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicles_id');
    }
}