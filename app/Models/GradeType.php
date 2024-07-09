<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeType extends Model
{
    use HasFactory;


    protected $table = 'grade_types';

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

    public function grade(){
        return $this->hasMany(Grade::class);
    }
}
