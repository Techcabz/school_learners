<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'learner_id',
        'school_class_id',
        'enrollment_date',
        'status'
    ];

    protected $casts = [
        'enrollment_date' => 'date'
    ];

    /**
     * Relationship with Learner
     */
    public function learner(): BelongsTo
    {
        return $this->belongsTo(Learner::class);
    }

    /**
     * Relationship with SchoolClass
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    /**
     * Relationship with QuarterlyGrades
     */
    public function quarterlyGrades(): HasMany
    {
        return $this->hasMany(QuarterlyGrade::class);
    }

    /**
     * Relationship with FinalGrades
     */
    public function finalGrades(): HasMany
    {
        return $this->hasMany(FinalGrade::class);
    }

    /**
     * Relationship with GeneralAverages
     */
    public function generalAverages(): HasMany
    {
        return $this->hasMany(GeneralAverage::class);
    }

    /**
     * Get formatted enrollment date
     */
    public function getFormattedEnrollmentDateAttribute(): string
    {
        return $this->enrollment_date->format('F j, Y');
    }

    /**
     * Get the school year through school class
     */
    public function schoolYear()
    {
        return $this->schoolClass->schoolYear();
    }

    /**
     * Get the grade level through school class
     */
    public function gradeLevel()
    {
        return $this->schoolClass->grade_level;
    }

    /**
     * Calculate days since enrollment
     */
    public function getDaysEnrolledAttribute(): int
    {
        return $this->enrollment_date->diffInDays(now());
    }

    /**
     * Check if enrollment is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Mark enrollment as transferred
     */
    public function markAsTransferred(): void
    {
        $this->update(['status' => 'transferred']);
    }

    /**
     * Mark enrollment as dropped
     */
    public function markAsDropped(): void
    {
        $this->update(['status' => 'dropped']);
    }

    /**
     * Scope for active enrollments
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for enrollments in current school year
     */
    public function scopeCurrentSchoolYear($query)
    {
        return $query->whereHas('schoolClass', function($q) {
            $q->whereHas('schoolYear', function($q2) {
                $q2->where('is_current', true);
            });
        });
    }

    /**
     * Scope for enrollments by grade level
     */
    public function scopeForGradeLevel($query, $gradeLevel)
    {
        return $query->whereHas('schoolClass', function($q) use ($gradeLevel) {
            $q->where('grade_level', $gradeLevel);
        });
    }

    /**
     * Get the current quarter average for a learning area
     */
    public function getCurrentQuarterAverage($learningAreaId)
    {
        return $this->quarterlyGrades()
            ->where('learning_area_id', $learningAreaId)
            ->whereHas('period', function($q) {
                $q->where('is_active', true);
            })
            ->avg('rating');
    }
}