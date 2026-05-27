<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['complainant_name', 'complainant_mobile', 'area', 'category', 'description', 'status', 'official_action', 'attachment_path', 'complaint_number'])]
class Complaint extends Model
{
    use HasFactory;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function ($complaint) {
            if (empty($complaint->complaint_number)) {
                do {
                    $complaint->complaint_number = 'CMP-' . date('ymd') . rand(1000, 9999);
                } while (static::where('complaint_number', $complaint->complaint_number)->exists());
            }
        });

        static::created(function ($complaint) {
            $complaint->logs()->create([
                'status' => $complaint->status,
                'message' => 'Grievance registered successfully.',
            ]);
        });
    }

    /**
     * Get the timeline logs for this complaint.
     */
    public function logs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ComplaintLog::class);
    }

    // Helper status checks
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isUnderReview(): bool
    {
        return $this->status === 'under_review';
    }

    public function isResolved(): bool
    {
        return $this->status === 'resolved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}
