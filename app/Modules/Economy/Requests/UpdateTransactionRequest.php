<?php

namespace App\Modules\Economy\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'account_type_id' => ['nullable', 'integer', 'exists:account_types,id'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'importo' => ['required', 'numeric', 'min:0.01'],
            'descrizione' => ['nullable', 'string', 'max:500'],
            'data' => ['required', 'date'],
            'note' => ['nullable', 'string', 'max:5000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'account_type_id' => 'tipo conto',
            'category_id' => 'categoria',
            'importo' => 'importo',
            'descrizione' => 'descrizione',
            'data' => 'data',
            'note' => 'note',
        ];
    }
}
