<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    public $timestamps = true;


    protected $fillable = [
        'user_id',
        'name',
        'nis',
        'gender',
        'birthplace',
        'birthdate',
        'religion',
        'blood_type',
        'phone',
        'address',
        'status',
        'class_id',
        'admission_date',
        'graduation_date',
        'photo'
    ];


    public function getDefaultStatus()
    {
        return [
            'inactive' => 'Inactive',
            'active' => 'Active',
        ];
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function grade()
    {
        return $this->hasMany(Grade::class);
    }
}
