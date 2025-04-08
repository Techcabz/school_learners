<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnrollmentEligibility extends Model
{
    use HasFactory;

    protected $fillable = [
        'learner_id',
        'school_id',
        'kinder_progress_report',
        'ecco_checklist',
        'kindergarten_certificate',
        'pbt_passer',
        'pbt_rating',
        'pbt_exam_date',
        'pbt_testing_center',
        'other_credential',
        'other_credential_specify',
        'remarks'
    ];

    protected $casts = [
        'kinder_progress_report' => 'boolean',
        'ecco_checklist' => 'boolean',
        'kindergarten_certificate' => 'boolean',
        'pbt_passer' => 'boolean',
        'other_credential' => 'boolean',
        'pbt_exam_date' => 'date'
    ];

    /**
     * Get the learner associated with this eligibility record
     */
    public function learner(): BelongsTo
    {
        return $this->belongsTo(Learner::class);
    }

    /**
     * Get the school associated with this eligibility record
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Check if learner has complete kindergarten credentials
     */
    public function hasCompleteKindergartenCredentials(): bool
    {
        return $this->kinder_progress_report 
            && $this->ecco_checklist 
            && $this->kindergarten_certificate;
    }

    /**
     * Get all submitted credentials as an array
     */
    public function getSubmittedCredentialsAttribute(): array
    {
        $credentials = [];

        if ($this->kinder_progress_report) {
            $credentials[] = 'Kindergarten Progress Report';
        }
        if ($this->ecco_checklist) {
            $credentials[] = 'ECCD Checklist';
        }
        if ($this->kindergarten_certificate) {
            $credentials[] = 'Kindergarten Certificate of Completion';
        }
        if ($this->pbt_passer) {
            $credentials[] = 'Philippine Validating Test (Rating: '.$this->pbt_rating.')';
        }
        if ($this->other_credential) {
            $credentials[] = $this->other_credential_specify;
        }

        return $credentials;
    }

    /**
     * Get formatted PBT exam date
     */
    public function getFormattedPbtExamDateAttribute(): ?string
    {
        return $this->pbt_exam_date?->format('F j, Y');
    }

    /**
     * Scope a query to only include eligible enrollments
     * (Has at least one valid credential)
     */
    public function scopeEligible($query)
    {
        return $query->where(function($q) {
            $q->where('kinder_progress_report', true)
              ->orWhere('ecco_checklist', true)
              ->orWhere('kindergarten_certificate', true)
              ->orWhere('pbt_passer', true)
              ->orWhere('other_credential', true);
        });
    }

    /**
     * Scope a query to only include records with PBT results
     */
    public function scopeWithPbt($query)
    {
        return $query->where('pbt_passer', true);
    }

    /**
     * Get the eligibility status as text
     */
    public function getEligibilityStatusAttribute(): string
    {
        if ($this->hasCompleteKindergartenCredentials()) {
            return 'Fully Eligible (Complete Kindergarten Credentials)';
        }

        if ($this->pbt_passer) {
            return 'Eligible (PBT Passer)';
        }

        if ($this->other_credential) {
            return 'Eligible (Other Credential: '.$this->other_credential_specify.')';
        }

        return 'Pending Eligibility';
    }
}