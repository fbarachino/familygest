<?php

namespace Database\Factories;

use App\Modules\FamilyMembers\Models\FamilyMember;
use Illuminate\Database\Eloquent\Factories\Factory;

class FamilyMemberFactory extends Factory
{
    protected $model = FamilyMember::class;

    public function definition(): array
    {
        $relazioni = ['padre', 'madre', 'figlio', 'figlia', 'nonno', 'nonna', 'zio', 'zia', 'cugino', 'cugina', 'altro'];

        return [
            'nome' => fake()->firstName(),
            'cognome' => fake()->lastName(),
            'data_nascita' => fake()->date('Y-m-d', '2010-01-01'),
            'luogo_nascita' => fake()->city(),
            'relazione' => fake()->randomElement($relazioni),
            'codice_fiscale' => fake()->unique()->regexify('[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]'),
            'telefono' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'indirizzo' => fake()->address(),
            'note' => fake()->optional()->sentence(),
        ];
    }
}
