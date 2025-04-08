<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QuarterlyGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'learning_area_id',
        'period_id',
        'rating',
        'remarks',
        'graded_by',
        'graded_at'
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'graded_at' => 'datetime'
    ];

    /**
     * Relationship with Enrollment
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Relationship with LearningArea
     */
    public function learningArea(): BelongsTo
    {
        return $this->belongsTo(LearningArea::class);
    }

    /**
     * Relationship with AcademicPeriod
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    /**
     * Relationship with Teacher who graded
     */
    public function gradedBy(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'graded_by');
    }

    /**
     * Relationship with FinalGrade
     */
    public function finalGrade(): HasOne
    {
        return $this->hasOne(FinalGrade::class, 'enrollment_id', 'enrollment_id')
            ->where('learning_area_id', $this->learning_area_id);
    }

    /**
     * Get formatted grade with two decimal places
     */
    public function getFormattedGradeAttribute(): string
    {
        return number_format($this->rating, 2);
    }

    /**
     * Check if grade is passing (≥ 75)
     */
    public function isPassing(): bool
    {
        return $this->rating >= 75;
    }

    /**
     * Get grade remark based on passing status
     */
    public function getGradeRemarkAttribute(): string
    {
        return $this->isPassing() ? 'PASSED' : 'FAILED';
    }

    /**
     * Scope for grades in current school year
     */
    public function scopeCurrentSchoolYear($query)
    {
        return $query->whereHas('enrollment.schoolClass.schoolYear', function($q) {
            $q->where('is_current', true);
        });
    }

    /**
     * Scope for grades in specific quarter
     */
    public function scopeForQuarter($query, $quarterNumber)
    {
        return $query->whereHas('period', function($q) use ($quarterNumber) {
            $q->where('order', $quarterNumber);
        });
    }

    /**
     * Scope for grades in specific subject
     */
    public function scopeForSubject($query, $learningAreaId)
    {
        return $query->where('learning_area_id', $learningAreaId);
    }

    /**
     * Scope for passing grades only
     */
    public function scopePassing($query)
    {
        return $query->where('rating', '>=', 75);
    }

    /**
     * Update final grade when quarterly grade changes
     */
    protected static function booted()
    {
        static::saved(function ($grade) {
            $grade->enrollment->updateFinalGrade($grade->learning_area_id);
        });
    }
}