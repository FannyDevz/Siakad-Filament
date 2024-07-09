<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'status',
        'code',
        'faculty_id',
        'accreditation',
    ];

    public function getDefaultStatus()
    {
        return [
            'inactive' => 'Inactive',
            'active' => 'Active',
        ];
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function class()
    {
        return $this->hasMany(ClassModel::class);
    }

}
