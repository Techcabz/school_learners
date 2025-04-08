<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Carbon\Carbon;

class SchoolYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_current'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean'
    ];

    /**
     * Get all classes for this school year
     */
    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class);
    }

    /**
     * Get all academic periods (quarters) for this school year
     */
    public function academicPeriods(): HasMany
    {
        return $this->hasMany(AcademicPeriod::class);
    }

    /**
     * Get all enrollments for this school year
     */
    public function enrollments(): HasManyThrough
    {
        return $this->hasManyThrough(
            Enrollment::class,
            SchoolClass::class,
            'school_year_id', // Foreign key on SchoolClass table
            'school_class_id', // Foreign key on Enrollment table
            'id', // Local key on SchoolYear table
            'id' // Local key on SchoolClass table
        );
    }

    /**
     * Get all learners enrolled in this school year
     */
    public function learners()
    {
        return $this->hasManyThrough(
            Learner::class,
            Enrollment::class,
            'school_class_id', // Foreign key on Enrollment table
            'id', // Foreign key on Learner table
            'id', // Local key on SchoolYear table
            'learner_id' // Local key on Enrollment table
        )->distinct();
    }

    /**
     * Get the current active quarter
     */
    public function currentQuarter()
    {
        return $this->academicPeriods()
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get formatted duration (e.g., "2023-2024 (Aug 2023 - May 2024)")
     */
    public function getFormattedDurationAttribute(): string
    {
        $start = Carbon::parse($this->start_date)->format('M Y');
        $end = Carbon::parse($this->end_date)->format('M Y');
        return "{$this->name} ({$start} - {$end})";
    }

    /**
     * Check if a date falls within this school year
     */
    public function containsDate($date): bool
    {
        $date = Carbon::parse($date);
        return $date->between(
            Carbon::parse($this->start_date),
            Carbon::parse($this->end_date)
        );
    }

    /**
     * Activate this school year (and deactivate others)
     */
    public function activate(): void
    {
        SchoolYear::where('id', '!=', $this->id)->update(['is_current' => false]);
        $this->update(['is_current' => true]);
    }

    /**
     * Scope a query to only include current school year
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    /**
     * Scope a query to order by most recent first
     */
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('start_date', 'desc');
    }
}