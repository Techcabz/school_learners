<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Learner extends Model
{
    use HasFactory;

    protected $fillable = [
        'lrn',
        'last_name',
        'first_name',
        'middle_name',
        'name_extension',
        'birthdate',
        'sex'
    ];

    protected $casts = [
        'birthdate' => 'date'
    ];

    /**
     * Get the enrollment eligibility record
     */
    public function enrollmentEligibility(): HasOne
    {
        return $this->hasOne(EnrollmentEligibility::class);
    }

    /**
     * Get all enrollments for the learner
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get current active enrollment
     */
    public function currentEnrollment()
    {
        return $this->enrollments()
            ->whereHas('schoolClass', function($query) {
                $query->whereHas('schoolYear', function($q) {
                    $q->where('is_current', true);
                });
            })
            ->where('status', 'active')
            ->first();
    }

    /**
     * Get all classes the learner belongs to
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'enrollments')
            ->withPivot('enrollment_date', 'status')
            ->withTimestamps();
    }

    /**
     * Get all quarterly grades
     */
    public function quarterlyGrades()
    {
        return $this->hasManyThrough(
            QuarterlyGrade::class,
            Enrollment::class
        );
    }

    /**
     * Get all final grades
     */
    public function finalGrades()
    {
        return $this->hasManyThrough(
            FinalGrade::class,
            Enrollment::class
        );
    }

    /**
     * Get full name attribute
     */
    public function getFullNameAttribute(): string
    {
        return trim(sprintf(
            '%s %s %s %s',
            $this->last_name,
            $this->first_name,
            $this->middle_name,
            $this->name_extension
        ));
    }

    /**
     * Get formal name (Last Name, First Name)
     */
    public function getFormalNameAttribute(): string
    {
        return $this->last_name . ', ' . $this->first_name . 
               ($this->middle_name ? ' ' . $this->middle_name : '');
    }

    /**
     * Get age in years
     */
    public function getAgeAttribute(): int
    {
        return $this->birthdate->age;
    }
}