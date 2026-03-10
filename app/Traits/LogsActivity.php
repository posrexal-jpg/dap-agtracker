<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Log an activity
     *
     * @param string $activityType
     * @param string $description
     * @param mixed $model
     * @param array|null $oldValues
     * @param array|null $newValues
     * @return ActivityLog
     */
    protected function logActivity(
        string $activityType,
        string $description,
        $model = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => $activityType,
            'description' => $description,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Log a create activity
     */
    protected function logCreate($model, string $description = null): ActivityLog
    {
        $modelName = class_basename($model);
        $description = $description ?? "Created {$modelName}: {$this->getModelIdentifier($model)}";
        
        return $this->logActivity(
            'create',
            $description,
            $model,
            null,
            $model->toArray()
        );
    }

    /**
     * Log an update activity
     */
    protected function logUpdate($model, array $oldValues, string $description = null): ActivityLog
    {
        $modelName = class_basename($model);
        $description = $description ?? "Updated {$modelName}: {$this->getModelIdentifier($model)}";
        
        return $this->logActivity(
            'update',
            $description,
            $model,
            $oldValues,
            $model->toArray()
        );
    }

    /**
     * Log a delete activity
     */
    protected function logDelete($model, string $description = null): ActivityLog
    {
        $modelName = class_basename($model);
        $description = $description ?? "Deleted {$modelName}: {$this->getModelIdentifier($model)}";
        
        return $this->logActivity(
            'delete',
            $description,
            $model,
            $model->toArray(),
            null
        );
    }

    /**
     * Log an approve activity
     */
    protected function logApprove($model, string $description = null): ActivityLog
    {
        $modelName = class_basename($model);
        $description = $description ?? "Approved {$modelName}: {$this->getModelIdentifier($model)}";
        
        return $this->logActivity(
            'approve',
            $description,
            $model,
            ['is_approved' => false],
            ['is_approved' => true]
        );
    }

    /**
     * Log a reject activity
     */
    protected function logReject($model, string $description = null): ActivityLog
    {
        $modelName = class_basename($model);
        $description = $description ?? "Rejected {$modelName}: {$this->getModelIdentifier($model)}";
        
        return $this->logActivity(
            'reject',
            $description,
            $model,
            ['is_approved' => true],
            ['is_approved' => false]
        );
    }

    /**
     * Log an export activity
     */
    protected function logExport(string $exportType, string $description = null): ActivityLog
    {
        $description = $description ?? "Exported {$exportType} report";
        
        return $this->logActivity(
            'export',
            $description
        );
    }

    /**
     * Log a login activity
     */
    protected function logLogin(string $description = 'Admin logged in'): ActivityLog
    {
        return $this->logActivity(
            'login',
            $description
        );
    }

    /**
     * Log a logout activity
     */
    protected function logLogout(string $description = 'Admin logged out'): ActivityLog
    {
        return $this->logActivity(
            'logout',
            $description
        );
    }

    /**
     * Log a view activity
     */
    protected function logView(string $resource, string $description = null): ActivityLog
    {
        $description = $description ?? "Viewed {$resource}";
        
        return $this->logActivity(
            'view',
            $description
        );
    }

    /**
     * Get a human-readable identifier for a model
     */
    private function getModelIdentifier($model): string
    {
        if (isset($model->name)) {
            return $model->name;
        }
        
        if (isset($model->title)) {
            return $model->title;
        }
        
        if (isset($model->email)) {
            return $model->email;
        }
        
        return "ID: {$model->id}";
    }
}
