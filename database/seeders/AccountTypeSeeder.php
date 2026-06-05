<?php

namespace Database\Seeders;

use App\Modules\Economy\Models\AccountType;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['nome' => 'Conto Corrente',     'icona' => 'fas fa-university',  'colore' => '#007bff'],
            ['nome' => 'Conto Risparmio',    'icona' => 'fas fa-piggy-bank', 'colore' => '#28a745'],
            ['nome' => 'Carta di Credito',   'icona' => 'fas fa-credit-card','colore' => '#dc3545'],
            ['nome' => 'Contanti',           'icona' => 'fas fa-money-bill', 'colore' => '#fd7e14'],
            ['nome' => 'PayPal',             'icona' => 'fab fa-cc-paypal',  'colore' => '#003087'],
            ['nome' => 'Buoni Pasto',        'icona' => 'fas fa-utensils',   'colore' => '#20c997'],
            ['nome' => 'Prepagon',           'icona' => 'fas fa-id-card',    'colore' => '#6f42c1'],
        ];

        foreach ($types as $type) {
            AccountType::create($type);
        }
    }
}
