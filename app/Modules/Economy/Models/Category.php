<?php

namespace App\Modules\Economy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'tipo',
        'nome',
        'icona',
        'colore',
    ];

    protected function casts(): array
    {
        return [
            'tipo' => 'string',
        ];
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
