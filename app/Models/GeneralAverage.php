<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GeneralAverage extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'period_id',
        'average',
        'subjects_count'
    ];

    protected $casts = [
        'average' => 'decimal:2',
        'subjects_count' => 'integer'
    ];

    /**
     * Relationship with Enrollment
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Relationship with AcademicPeriod (quarter)
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    /**
     * Relationship with FinalGrades used to calculate this average
     */
    public function finalGrades()
    {
        return $this->hasMany(FinalGrade::class, 'enrollment_id', 'enrollment_id')
            ->where(function($query) {
                if ($this->period_id) {
                    // For quarterly averages, include only grades from completed quarters
                    $query->whereHas('quarterlyGrades', function($q) {
                        $q->where('period_id', '<=', $this->period_id);
                    });
                }
                // For yearly average, include all final grades
            });
    }

    /**
     * Get formatted average with two decimal places
     */
    public function getFormattedAverageAttribute(): string
    {
        return number_format($this->average, 2);
    }

    /**
     * Check if average meets passing standard (≥ 75)
     */
    public function isPassing(): bool
    {
        return $this->average >= 75;
    }

    /**
     * Get honorific classification based on average
     */
    public function getHonorificAttribute(): string
    {
        if ($this->average >= 90) return 'With Honors';
        if ($this->average >= 85) return 'With High Honors';
        if ($this->average >= 80) return 'With Highest Honors';
        return $this->isPassing() ? 'Passed' : 'Failed';
    }

    /**
     * Recalculate the general average from final grades
     */
    public function recalculate(): void
    {
        $grades = $this->finalGrades;
        $average = $grades->avg('rating');
        $count = $grades->count();

        $this->update([
            'average' => $average,
            'subjects_count' => $count
        ]);
    }

    /**
     * Scope for quarterly averages
     */
    public function scopeQuarterly($query)
    {
        return $query->whereNotNull('period_id');
    }

    /**
     * Scope for final yearly averages
     */
    public function scopeYearly($query)
    {
        return $query->whereNull('period_id');
    }

    /**
     * Scope for passing averages only
     */
    public function scopePassing($query)
    {
        return $query->where('average', '>=', 75);
    }

    /**
     * Scope for averages in current school year
     */
    public function scopeCurrentSchoolYear($query)
    {
        return $query->whereHas('enrollment.schoolClass.schoolYear', function($q) {
            $q->where('is_current', true);
        });
    }

    /**
     * Automatically recalculate when related grades change
     */
    protected static function booted()
    {
        static::saved(function ($average) {
            $average->enrollment->updateGeneralAverages();
        });
    }
}