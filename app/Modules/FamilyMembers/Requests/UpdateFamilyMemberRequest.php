<?php

namespace App\Modules\FamilyMembers\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFamilyMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'cognome' => ['required', 'string', 'max:255'],
            'data_nascita' => ['required', 'date', 'before:today'],
            'luogo_nascita' => ['nullable', 'string', 'max:255'],
            'relazione' => ['required', 'string', 'in:padre,madre,figlio,figlia,nonno,nonna,zio,zia,cugino,cugina,altro'],
            'codice_fiscale' => ['nullable', 'string', 'size:16', Rule::unique('family_members', 'codice_fiscale')->ignore($this->route('family_member'))],
            'telefono' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'indirizzo' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'note' => ['nullable', 'string', 'max:5000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nome' => 'nome',
            'cognome' => 'cognome',
            'data_nascita' => 'data di nascita',
            'luogo_nascita' => 'luogo di nascita',
            'relazione' => 'relazione',
            'codice_fiscale' => 'codice fiscale',
            'telefono' => 'telefono',
            'email' => 'email',
            'indirizzo' => 'indirizzo',
            'foto' => 'foto',
            'note' => 'note',
        ];
    }
}
