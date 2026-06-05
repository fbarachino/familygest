<?php

namespace App\Modules\FamilyMembers\Models;

use Carbon\Carbon;
use Database\Factories\FamilyMemberFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class FamilyMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'cognome',
        'data_nascita',
        'luogo_nascita',
        'relazione',
        'codice_fiscale',
        'telefono',
        'email',
        'indirizzo',
        'foto',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'data_nascita' => 'date:Y-m-d',
        ];
    }

    public function getAgeAttribute(): int
    {
        return Carbon::parse($this->data_nascita)->age;
    }

    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto) {
            return null;
        }

        return Storage::url($this->foto);
    }

    protected static function newFactory(): FamilyMemberFactory
    {
        return FamilyMemberFactory::new();
    }
}
