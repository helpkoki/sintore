<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $table = 'incidents'; // Table name
    protected $primaryKey = 'tick_id'; // Primary key
    public $timestamps = false; // Disable Laravel's default timestamps

    protected $fillable = [
        'tick_id', 'date', 'os', 'department', 'description', 'status', 'path',
        'user_id', 'technician_id', 'company_id', 'priority'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id', 'technician_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
}
