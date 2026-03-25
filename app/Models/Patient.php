<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'allergies',
        'chronic_conditions',
        'surgical_history',
        'observations',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
    ];


    //Relacion uno a uno inversa
    public function user(){
        return $this->belongsTo(User::class);
    }

    //Relacion uno a muchos
    public function bloodType(){
        return $this->belongsTo(BloodType::class);
    }
}
