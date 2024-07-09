<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;


    protected $table = 'schedules';

    public $timestamps = true;

    protected $fillable = [
        'class_id',
        'room_id',
        'teacher_id',
        'course_id',
        'day',
        'start_time',
        'end_time',
    ];


    public function class()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
