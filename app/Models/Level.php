<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'levels';

    public $timestamps = true;

    protected $fillable = [
        'name',
    ];

    public function class()
    {
        return $this->hasMany(ClassModel::class);
    }
}
