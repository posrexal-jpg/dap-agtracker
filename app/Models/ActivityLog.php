<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event',
        'subject_type',
        'subject_id',
        'description',
        'metadata',
        'ip_address',
        'user_agent',
    ];

    protected $casts = ['metadata' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $event, Model $subject, string $description): void
    {
        if (! Schema::hasTable('activity_logs')) {
            return;
        }

        $request = request();
        $user = $request?->user();

        static::create([
            'user_id' => $user?->id,
            'event' => $event,
            'subject_type' => class_basename($subject),
            'subject_id' => $subject->getKey(),
            'description' => $description,
            'metadata' => ['changed_fields' => array_keys($subject->getChanges())],
            'ip_address' => $request?->ip(),
            'user_agent' => mb_substr((string) $request?->userAgent(), 0, 1000),
        ]);
    }
}
