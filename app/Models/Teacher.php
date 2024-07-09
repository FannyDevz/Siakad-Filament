<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    public $timestamps = true;


    protected $fillable = [
        'user_id',
        'name',
        'nik',
        'nip',
        'gender',
        'birthplace',
        'birthdate',
        'religion',
        'blood_type',
        'phone',
        'address',
        'status',
        'photo',
        'join_date'
    ];

    public function getDefaultStatus()
    {
        return [
            'inactive' => 'Inactive',
            'active' => 'Active',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }
}
