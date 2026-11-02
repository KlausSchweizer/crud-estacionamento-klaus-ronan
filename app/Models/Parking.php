<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Parking extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['vehicles_id', 'horarios_entrada']);
    }
}
