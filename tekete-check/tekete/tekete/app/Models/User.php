<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users'; // Table name
    protected $primaryKey = 'user_id'; // Primary key
    public $timestamps = false; // Disable Laravel's default timestamps

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'company_id', 
        'password',
        'date_registered'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_registered' => 'datetime',
    ];

    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }


    // Relationships
    public function incidents()
    {
        return $this->hasMany(Incident::class, 'user_id', 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

}

