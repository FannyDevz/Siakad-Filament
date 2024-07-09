<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;


    protected $table = 'settings';

    public $timestamps = true;

    protected $fillable = [
        'key',
        'value',
    ];

    public function get()
    {
        return $this->value;
    }

    public function set($value)
    {
        $this->value = $value;
        $this->save();
    }
}
