<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'code', 
        'display_order', 
        'is_core',
        'description',
        'is_active'
    ];
    
    protected $casts = [
        'is_core' => 'boolean',
        'is_active' => 'boolean',
        'display_order' => 'integer'
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::creating(function ($learningArea) {
            // Generate code automatically if not provided
            if (empty($learningArea->code)) {
                $learningArea->code = static::generateCode($learningArea->name);
            }
        });
    }

    /**
     * Generate a standardized code from the learning area name
     */
    public static function generateCode(string $name): string
    {
        $specialCases = [
            'Araling Panlipunan' => 'AP',
            'Edukasyon sa Pagpapakatao' => 'ESP',
            'Islamic Values Education' => 'IVE',
            'Physical Education' => 'PE'
        ];

        if (array_key_exists($name, $specialCases)) {
            return $specialCases[$name];
        }

        // Convert name to acronym
        $words = preg_split('/\s+/', $name);
        $code = '';
        
        foreach ($words as $word) {
            $code .= strtoupper(substr($word, 0, 1));
        }
        
        return $code;
    }

    /**
     * Scope a query to only include core learning areas.
     */
    public function scopeCore($query)
    {
        return $query->where('is_core', true);
    }

    /**
     * Scope a query to only include active learning areas.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by display order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    /**
     * Get all learning areas ordered by display order
     */
    public static function getOrderedList()
    {
        return static::active()->ordered()->get();
    }

    /**
     * Relationship with quarterly grades
     */
    public function quarterlyGrades()
    {
        return $this->hasMany(QuarterlyGrade::class);
    }

    /**
     * Relationship with final grades
     */
    public function finalGrades()
    {
        return $this->hasMany(FinalGrade::class);
    }
}