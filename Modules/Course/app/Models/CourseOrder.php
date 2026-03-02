<?php

namespace Modules\Course\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseOrder extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'amount',
        'currency',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
