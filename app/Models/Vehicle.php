<?php

namespace App\Models;

use Database\Factories\VehicleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Vehicle extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;
    protected $fillable = [
        'brand',
        'model',
        'color',
        'plate',
    ];

    public function parkings()
    {
        return $this->hasMany(Parking::class, 'vehicles_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = session('user');

        if ($user) {
            $activity->causer_type = User::class;
            $activity->causer_id   = is_object($user) ? $user->id : $user;
        }

        $activity->description = "O veículo {$this->model} ({$this->plate}) foi " . match($eventName) {
                'created' => 'cadastrado',
                'updated' => 'atualizado',
                'deleted' => 'excluído',
                default   => $eventName,
            };
    }
}
