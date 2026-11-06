<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
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
        'spots_id',
        'horario_entrada',
        'horario_saida',
        'preco',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicles_id');
    }

    public function spot()
    {
        return $this->belongsTo(Spot::class, 'spots_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = session('user');

        if ($user) {
            $activity->causer_type = User::class;
            $activity->causer_id   = is_object($user) ? $user->id : $user;
        }

        $activity->description = "O ticket {$this->ticket} foi " . match($eventName) {
                'created' => 'cadastrado',
                'updated' => 'atualizado',
                'deleted' => 'excluído',
                default   => $eventName,
            };
    }
}
