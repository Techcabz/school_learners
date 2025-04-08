<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'address',
        'district',
        'division',
        'region'
    ];

    /**
     * Get all classes belonging to this school
     */
    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class);
    }

    /**
     * Get all enrollment eligibility records for this school
     */
    public function enrollmentEligibilities(): HasMany
    {
        return $this->hasMany(EnrollmentEligibility::class);
    }

    /**
     * Get all teachers associated with this school
     */
    public function teachers()
    {
        return $this->hasManyThrough(
            Teacher::class,
            SchoolClass::class,
            'school_id', // Foreign key on SchoolClass table
            'id',        // Foreign key on Teacher table
            'id',        // Local key on School table
            'adviser_id' // Local key on SchoolClass table
        );
    }

    /**
     * Get all learners enrolled in this school
     */
    public function learners()
    {
        return $this->hasManyThrough(
            Learner::class,
            Enrollment::class,
            'school_id', // Foreign key on Enrollment table
            'id',        // Foreign key on Learner table
            'id',        // Local key on School table
            'learner_id' // Local key on Enrollment table
        )->distinct();
    }

    /**
     * Get full school address with hierarchy
     */
    public function getFullAddressAttribute(): string
    {
        return implode(', ', array_filter([
            $this->address,
            $this->district,
            $this->division,
            $this->region
        ]));
    }

    /**
     * Get official school identifier
     */
    public function getOfficialNameAttribute(): string
    {
        return "{$this->name} (ID: {$this->school_id})";
    }

    /**
     * Scope a query to only include schools in a specific region
     */
    public function scopeInRegion($query, string $region)
    {
        return $query->where('region', $region);
    }

    /**
     * Scope a query to only include schools in a specific division
     */
    public function scopeInDivision($query, string $division)
    {
        return $query->where('division', $division);
    }

    /**
     * Get active school years for this school
     */
    public function activeSchoolYears()
    {
        return $this->classes()
            ->with('schoolYear')
            ->get()
            ->pluck('schoolYear')
            ->unique()
            ->filter(function($year) {
                return $year->is_current;
            });
    }
}