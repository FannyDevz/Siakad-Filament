<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semesters';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'status',
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
        return $this->hasMany(ClassModel::class);
    }
}
