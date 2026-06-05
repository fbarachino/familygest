<?php

namespace App\Modules\Economy\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'icona' => ['nullable', 'string', 'max:100'],
            'colore' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nome' => 'nome',
            'icona' => 'icona',
            'colore' => 'colore',
        ];
    }
}
