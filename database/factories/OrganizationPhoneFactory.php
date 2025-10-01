<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationPhoneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'phone_number' => fake()->numerify('+7 9## ###-##-##'),
        ];
    }
}
