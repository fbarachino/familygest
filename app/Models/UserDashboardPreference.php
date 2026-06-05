<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDashboardPreference extends Model
{
    protected $fillable = [
        'user_id',
        'widget_id',
        'enabled',
        'order',
        'column_width',
    ];

    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
            'order' => 'integer',
            'column_width' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
