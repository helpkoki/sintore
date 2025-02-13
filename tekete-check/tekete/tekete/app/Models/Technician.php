<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;


class Technician extends Authenticatable
{
    use Notifiable;

    protected $table = 'technician'; // Specify the exact table name

    protected $primaryKey = 'technician_id'; // Custom primary key
    public $incrementing = true; // If 'technician_id' is non-incrementing
    protected $keyType = 'int'; // Primary key type
    
    // Enable timestamps since they exist in your migration
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'technician_id',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'level',
        'randomstring',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'technician_id' => 'integer',
        'level' => 'integer',
    ];

    /**
     * Hash the password before saving to the database.
     *
     * @param string $value
     */
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = Hash::make($value);
    // }

    public function incidents()
    {
        return $this->hasMany(Incident::class, 'technician_id');
    }
}


