<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Voucher extends Model
{
    use HasFactory, softDeletes, LogsActivity;

    protected $fillable = ['code', 'name', 'discount'];

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

        $activity->description = "O voucher {$this->code} foi " . match($eventName) {
                'created' => 'cadastrado',
                'updated' => 'atualizado',
                'deleted' => 'excluído',
                default   => $eventName,
            };
    }
}
