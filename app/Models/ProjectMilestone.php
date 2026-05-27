<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['project_timeline_id', 'title', 'description', 'status', 'milestone_date'])]
class ProjectMilestone extends Model
{
    use HasFactory;

    /**
     * Get the project timeline that owns this milestone.
     */
    public function projectTimeline(): BelongsTo
    {
        return $this->belongsTo(ProjectTimeline::class);
    }
}
