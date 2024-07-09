<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculties';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'status',
        'code',
    ];

    public function getDefaultStatus()
    {
        return [
            'inactive' => 'Inactive',
            'active' => 'Active',
        ];
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
