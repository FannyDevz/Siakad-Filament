<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'code',
        'description',
        'sks',
        'type',
        'status',
    ];

    public function getDefaultType()
    {
        return [
            'general' => 'General',
            'special' => 'Special',
        ];
    }

    public function getDefaultStatus()
    {
        return [
            'inactive' => 'Inactive',
            'active' => 'Active',
        ];
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

    public function grade()
    {
        return $this->hasMany(Grade::class);
    }
}
