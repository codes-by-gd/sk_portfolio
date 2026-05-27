<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['project_name', 'location', 'budget', 'start_date', 'target_completion', 'current_phase', 'status', 'notes'])]
class ProjectTimeline extends Model
{
    use HasFactory;

    /**
     * Get the milestones for the project timeline.
     */
    public function milestones(): HasMany
    {
        return $this->hasMany(ProjectMilestone::class)->orderBy('milestone_date', 'asc');
    }

    /**
     * Get dynamic progress percentage.
     */
    public function getProgressPercentAttribute(): int
    {
        $total = $this->milestones()->count();
        if ($total === 0) {
            return $this->status === 'completed' ? 100 : 0;
        }

        $completed = $this->milestones()->where('status', 'completed')->count();
        return (int) round(($completed / $total) * 100);
    }
}
