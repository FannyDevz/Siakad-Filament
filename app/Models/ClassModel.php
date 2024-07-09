<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'status',
        'academic_year_id',
        'semester_id',
        'department_id',
        'level_id',
        'teacher_id',
    ];

    public function labelSelect(){
        $level = $this->level();
        return $level->first()->name . ' - ' . $this->name;
    }

    public function getDefaultStatus()
    {
        return [
            'inactive' => 'Inactive',
            'active' => 'Active',
        ];
    }


    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }


}
