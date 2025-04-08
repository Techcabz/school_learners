<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class AcademicPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_year_id',
        'name',
        'order',
        'code',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    /**
     * Relationship with SchoolYear
     */
    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    /**
     * Relationship with QuarterlyGrades
     */
    public function quarterlyGrades(): HasMany
    {
        return $this->hasMany(QuarterlyGrade::class, 'period_id');
    }

    /**
     * Get formatted date range (e.g., "Q1: Aug 1 - Oct 31, 2023")
     */
    public function getFormattedDateRangeAttribute(): string
    {
        $start = Carbon::parse($this->start_date)->format('M j');
        $end = Carbon::parse($this->end_date)->format('M j, Y');
        return "{$this->code}: {$start} - {$end}";
    }

    /**
     * Check if period is currently active based on dates
     */
    public function getIsCurrentlyActiveAttribute(): bool
    {
        $now = now();
        return $now->between(
            Carbon::parse($this->start_date),
            Carbon::parse($this->end_date)
        );
    }

    /**
     * Activate this period and deactivate others
     */
    public function activate(): void
    {
        AcademicPeriod::where('id', '!=', $this->id)
            ->update(['is_active' => false]);
            
        $this->update(['is_active' => true]);
    }

    /**
     * Get the next period in sequence
     */
    public function nextPeriod()
    {
        return AcademicPeriod::where('school_year_id', $this->school_year_id)
            ->where('order', $this->order + 1)
            ->first();
    }

    /**
     * Get the previous period in sequence
     */
    public function previousPeriod()
    {
        return AcademicPeriod::where('school_year_id', $this->school_year_id)
            ->where('order', $this->order - 1)
            ->first();
    }

    /**
     * Scope for current active period
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for periods in current school year
     */
    public function scopeCurrentSchoolYear($query)
    {
        return $query->whereHas('schoolYear', function($q) {
            $q->where('is_current', true);
        });
    }

    /**
     * Scope for periods ordered sequentially
     */
    public function scopeInOrder($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Check if a date falls within this period
     */
    public function containsDate($date): bool
    {
        $date = Carbon::parse($date);
        return $date->between(
            Carbon::parse($this->start_date),
            Carbon::parse($this->end_date)
        );
    }
}