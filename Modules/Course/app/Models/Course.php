<?php

namespace Modules\Course\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Batch\Models\Batch;
// use Modules\Course\Database\Factories\CourseFactory;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'status',
        'created_by',
    ];

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class, 'course_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        $thumb = $this->thumbnail;
        if (!is_string($thumb)) {
            return null;
        }

        $thumb = trim($thumb);
        if ($thumb === '') {
            return null;
        }

        if (Str::startsWith($thumb, ['http://', 'https://'])) {
            return $thumb;
        }

        $normalized = ltrim($thumb, '/');
        if (Str::startsWith($normalized, 'storage/')) {
            $normalized = Str::after($normalized, 'storage/');
        }

        return Storage::disk('public')->url($normalized);
    }

    // protected static function newFactory(): CourseFactory
    // {
    //     // return CourseFactory::new();
    // }
}
