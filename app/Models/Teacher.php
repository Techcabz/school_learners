<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'name_extension',
        'email',
        'phone',
        'gender',
        'birthdate',
        'employee_id',
        'position',
        'is_active'
    ];

    protected $casts = [
        'birthdate' => 'date',
        'is_active' => 'boolean'
    ];

    /**
     * Relationship with SchoolClass (as adviser)
     */
    public function advisoryClasses(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'adviser_id');
    }

    /**
     * Relationship with QuarterlyGrades (graded by)
     */
    public function gradedGrades(): HasMany
    {
        return $this->hasMany(QuarterlyGrade::class, 'graded_by');
    }

    /**
     * Relationship with Schools (through classes)
     */
    public function schools(): BelongsToMany
    {
        return $this->belongsToMany(School::class, 'school_classes', 'adviser_id', 'school_id')
            ->withTimestamps()
            ->distinct();
    }

    /**
     * Relationship with User account
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get full name with title
     */
    public function getFullNameAttribute(): string
    {
        $title = $this->gender === 'Female' ? 'Ms.' : 'Mr.';
        return "$title {$this->last_name}, {$this->first_name}" . 
               ($this->middle_name ? ' ' . $this->middle_name : '') .
               ($this->name_extension ? ' ' . $this->name_extension : '');
    }

    /**
     * Get formal name (Last Name, First Name)
     */
    public function getFormalNameAttribute(): string
    {
        return "{$this->last_name}, {$this->first_name}";
    }

    /**
     * Get current advisory class
     */
    public function currentAdvisoryClass()
    {
        return $this->advisoryClasses()
            ->whereHas('schoolYear', function($q) {
                $q->where('is_current', true);
            })
            ->first();
    }

    /**
     * Get subjects taught (through classes)
     */
    public function subjectsTaught()
    {
        return $this->hasManyThrough(
            LearningArea::class,
            SchoolClass::class,
            'adviser_id',
            'id',
            'id',
            'id' // This needs adjustment based on your actual structure
        )->distinct();
    }

    /**
     * Scope for active teachers only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for teachers in specific school
     */
    public function scopeInSchool($query, $schoolId)
    {
        return $query->whereHas('advisoryClasses', function($q) use ($schoolId) {
            $q->where('school_id', $schoolId);
        });
    }

    /**
     * Activate teacher account
     */
    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }

    /**
     * Deactivate teacher account
     */
    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }

    /**
     * Check if teacher has user account
     */
    public function hasUserAccount(): bool
    {
        return $this->user()->exists();
    }
}