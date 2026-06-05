<?php

namespace App\Modules\Economy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'account_type_id',
        'category_id',
        'importo',
        'descrizione',
        'data',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'importo' => 'decimal:2',
            'data' => 'date:Y-m-d',
        ];
    }

    public function accountType(): BelongsTo
    {
        return $this->belongsTo(AccountType::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
