<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Company extends Authenticatable
{
    use Notifiable;

    protected $table = 'company'; // Table name
    protected $primaryKey = 'company_id'; // Primary key
    public $timestamps = false; // Disable Laravel's default timestamps

    protected $fillable = [
        'c_name',
        'c_email',
        'c_type',
        'date_added',
        'admin_no',
        'password',
        'random',
    ];

    protected $hidden = [
        'password',
        'random'
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

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class, 'company_id', 'company_id');
    }
}
