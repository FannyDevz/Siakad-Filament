<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'status',
        'capacity',
        'type',
    ];

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
}
