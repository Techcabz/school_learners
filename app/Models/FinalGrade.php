<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinalGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'learning_area_id',
        'rating',
        'remarks',
        'quarters_count',
        'is_completed'
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'quarters_count' => 'integer',
        'is_completed' => 'boolean'
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
     * Relationship with QuarterlyGrades
     */
    public function quarterlyGrades(): HasMany
    {
        return $this->hasMany(QuarterlyGrade::class, 'enrollment_id', 'enrollment_id')
            ->where('learning_area_id', $this->learning_area_id);
    }

    /**
     * Get formatted final grade
     */
    public function getFormattedGradeAttribute(): string
    {
        return number_format($this->rating, 2);
    }

    /**
     * Check if final grade is passing (≥ 75)
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
        if (!$this->is_completed) {
            return 'INCOMPLETE';
        }
        return $this->isPassing() ? 'PASSED' : 'FAILED';
    }

    /**
     * Calculate final grade from quarterly grades
     */
    public function calculateFromQuarterlyGrades(): void
    {
        $average = $this->quarterlyGrades()->avg('rating');
        $count = $this->quarterlyGrades()->count();

        $this->update([
            'rating' => $average,
            'quarters_count' => $count,
            'is_completed' => $count >= 4 // Mark complete if all quarters are in
        ]);
    }

    /**
     * Scope for completed final grades
     */
    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    /**
     * Scope for passing final grades
     */
    public function scopePassing($query)
    {
        return $query->where('rating', '>=', 75);
    }

    /**
     * Scope for grades in specific subject
     */
    public function scopeForSubject($query, $learningAreaId)
    {
        return $query->where('learning_area_id', $learningAreaId);
    }

    /**
     * Scope for final grades in current school year
     */
    public function scopeCurrentSchoolYear($query)
    {
        return $query->whereHas('enrollment.schoolClass.schoolYear', function($q) {
            $q->where('is_current', true);
        });
    }
}