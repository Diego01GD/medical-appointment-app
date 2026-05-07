<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'specialty',
        'license_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
