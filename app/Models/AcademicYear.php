<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $table = 'academic_years';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
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
