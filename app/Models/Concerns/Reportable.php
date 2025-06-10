<?php

namespace App\Models\Concerns;

use App\Models\Report;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Reportable
{
    /**
     * Bu modele ait bildiriler
     */
    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    /**
     * Bekleyen bildiriler
     */
    public function pendingReports(): MorphMany
    {
        return $this->reports()->where('status', 'pending');
    }

    /**
     * Bildiri sayısı
     */
    public function getReportsCountAttribute(): int
    {
        return $this->reports()->count();
    }

    /**
     * Bekleyen bildiri sayısı
     */
    public function getPendingReportsCountAttribute(): int
    {
        return $this->pendingReports()->count();
    }

    /**
     * Bu içerik belirli bir kullanıcı tarafından bildirilmiş mi?
     */
    public function isReportedBy(int $userId): bool
    {
        return $this->reports()
            ->where('reporter_id', $userId)
            ->exists();
    }

    /**
     * Bu içeriğin çok fazla bildirimi var mı?
     */
    public function hasExcessiveReports(int $threshold = 5): bool
    {
        return $this->pending_reports_count >= $threshold;
    }
} 