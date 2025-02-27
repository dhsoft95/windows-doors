<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ViewLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'viewable_type',
        'viewable_id',
        'ip_address',
        'user_agent',
        'user_id',
    ];

    /**
     * Get the viewable model (product or article)
     */
    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who viewed the content
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log a view for a product or article
     */
    public static function log($model, $request)
    {
        return self::create([
            'viewable_type' => get_class($model),
            'viewable_id' => $model->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user_id' => $request->user()?->id,
        ]);
    }

    /**
     * Get unique views count
     */
    public static function uniqueViews($model)
    {
        return self::where('viewable_type', get_class($model))
            ->where('viewable_id', $model->id)
            ->distinct('ip_address')
            ->count('ip_address');
    }

    /**
     * Get total views count
     */
    public static function totalViews($model)
    {
        return self::where('viewable_type', get_class($model))
            ->where('viewable_id', $model->id)
            ->count();
    }
}
