<?php

namespace Modules\Batch\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Course\Models\Course;
// use Modules\Batch\Database\Factories\BatchFactory;

class Batch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'course_id',
        'name',
        'start_date',
        'end_date',
        'class_days',
        'class_time',
        'status',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'class_days' => 'array',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function mentors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'batch_mentors', 'batch_id', 'mentor_id')
            ->withTimestamps();
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'batch_students', 'batch_id', 'student_id')
            ->withTimestamps();
    }

    public function classSchedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class, 'batch_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // protected static function newFactory(): BatchFactory
    // {
    //     // return BatchFactory::new();
    // }
}
