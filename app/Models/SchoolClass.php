<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'school_year_id',
        'grade_level',
        'section',
        'adviser_id'
    ];

    /**
     * Get the school this class belongs to
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the school year this class belongs to
     */
    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    /**
     * Get the adviser/teacher for this class
     */
    public function adviser(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'adviser_id');
    }

    /**
     * Get all enrollments for this class
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get all learners enrolled in this class
     */
    public function learners(): BelongsToMany
    {
        return $this->belongsToMany(Learner::class, 'enrollments')
            ->withPivot(['enrollment_date', 'status'])
            ->withTimestamps();
    }

    /**
     * Get all quarterly grades for this class
     */
    public function quarterlyGrades()
    {
        return $this->hasManyThrough(
            QuarterlyGrade::class,
            Enrollment::class
        );
    }

    /**
     * Get the class name in standard format (e.g., "Grade 1 - Section A")
     */
    public function getFullClassNameAttribute(): string
    {
        return "Grade {$this->grade_level} - {$this->section}";
    }

    /**
     * Get the official class identifier (e.g., "G1-A (2023-2024)")
     */
    public function getOfficialClassIdAttribute(): string
    {
        return "G{$this->grade_level}-{$this->section} ({$this->schoolYear->name})";
    }

    /**
     * Get the number of enrolled learners
     */
    public function getEnrollmentCountAttribute(): int
    {
        return $this->enrollments()->count();
    }

    /**
     * Check if the class has available slots
     */
    public function hasAvailableSlots(int $maxCapacity = 40): bool
    {
        return $this->enrollment_count < $maxCapacity;
    }

    /**
     * Scope a query to only include classes for a specific grade level
     */
    public function scopeForGradeLevel($query, int $gradeLevel)
    {
        return $query->where('grade_level', $gradeLevel);
    }

    /**
     * Scope a query to only include classes in current school year
     */
    public function scopeCurrent($query)
    {
        return $query->whereHas('schoolYear', function($q) {
            $q->where('is_current', true);
        });
    }

    /**
     * Get the class average for a specific learning area and period
     */
    public function getClassAverage(int $learningAreaId, int $periodId = null): ?float
    {
        $query = $this->quarterlyGrades()
            ->where('learning_area_id', $learningAreaId);

        if ($periodId) {
            $query->where('period_id', $periodId);
        }

        return $query->avg('rating');
    }
}