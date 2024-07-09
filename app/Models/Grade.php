<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grades';

    public $timestamps = true;


    protected $fillable = [
      'student_id',
      'course_id',
      'grade_type_id',
      'value',
      'description',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function gradeType()
    {
        return $this->belongsTo(GradeType::class);
    }

}
