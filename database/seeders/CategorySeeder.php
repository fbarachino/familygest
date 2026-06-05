<?php

namespace Database\Seeders;

use App\Modules\Economy\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Entrate
            ['tipo' => 'entrata', 'nome' => 'Stipendio',          'icona' => 'fas fa-briefcase',      'colore' => '#28a745'],
            ['tipo' => 'entrata', 'nome' => 'Freelance',          'icona' => 'fas fa-laptop',         'colore' => '#17a2b8'],
            ['tipo' => 'entrata', 'nome' => 'Affitti',            'icona' => 'fas fa-home',           'colore' => '#ffc107'],
            ['tipo' => 'entrata', 'nome' => 'Interessi',          'icona' => 'fas fa-percentage',     'colore' => '#007bff'],
            ['tipo' => 'entrata', 'nome' => 'Vendite',            'icona' => 'fas fa-tags',           'colore' => '#6f42c1'],
            ['tipo' => 'entrata', 'nome' => 'Rimborsi',           'icona' => 'fas fa-undo',           'colore' => '#20c997'],
            ['tipo' => 'entrata', 'nome' => 'Regali',             'icona' => 'fas fa-gift',           'colore' => '#e83e8c'],
            ['tipo' => 'entrata', 'nome' => 'Altro',              'icona' => 'fas fa-plus-circle',    'colore' => '#adb5bd'],

            // Spese
            ['tipo' => 'spesa',   'nome' => 'Alimentari',         'icona' => 'fas fa-shopping-basket','colore' => '#dc3545'],
            ['tipo' => 'spesa',   'nome' => 'Bollette',           'icona' => 'fas fa-file-invoice',   'colore' => '#fd7e14'],
            ['tipo' => 'spesa',   'nome' => 'Affitto/Mutuo',      'icona' => 'fas fa-home',           'colore' => '#e74c3c'],
            ['tipo' => 'spesa',   'nome' => 'Trasporti',          'icona' => 'fas fa-car',            'colore' => '#343a40'],
            ['tipo' => 'spesa',   'nome' => 'Abbonamenti',        'icona' => 'fas fa-users',          'colore' => '#007bff'],
            ['tipo' => 'spesa',   'nome' => 'Svago',              'icona' => 'fas fa-film',           'colore' => '#9b59b6'],
            ['tipo' => 'spesa',   'nome' => 'Ristoranti',         'icona' => 'fas fa-utensils',       'colore' => '#e67e22'],
            ['tipo' => 'spesa',   'nome' => 'Salute',             'icona' => 'fas fa-heartbeat',      'colore' => '#e74c3c'],
            ['tipo' => 'spesa',   'nome' => 'Vestiti',            'icona' => 'fas fa-tshirt',         'colore' => '#8e44ad'],
            ['tipo' => 'spesa',   'nome' => 'Scuola',             'icona' => 'fas fa-book',           'colore' => '#2c3e50'],
            ['tipo' => 'spesa',   'nome' => 'Animali',            'icona' => 'fas fa-paw',            'colore' => '#d35400'],
            ['tipo' => 'spesa',   'nome' => 'Regali',             'icona' => 'fas fa-gift',           'colore' => '#c0392b'],
            ['tipo' => 'spesa',   'nome' => 'Viaggi',             'icona' => 'fas fa-plane',          'colore' => '#2980b9'],
            ['tipo' => 'spesa',   'nome' => 'Casa (manutenzione)','icona' => 'fas fa-tools',          'colore' => '#7f8c8d'],
            ['tipo' => 'spesa',   'nome' => 'Tasse',              'icona' => 'fas fa-file-invoice-dollar','colore' => '#c0392b'],
            ['tipo' => 'spesa',   'nome' => 'Varie',              'icona' => 'fas fa-ellipsis-h',     'colore' => '#95a5a6'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
