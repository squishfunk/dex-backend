<?php

namespace Database\Factories;

use App\Models\Token;
use Illuminate\Database\Eloquent\Factories\Factory;

class TokenFactory extends Factory
{
    protected $model = Token::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'symbol' => strtoupper($this->faker->lexify('???')),
            'supply' => $this->faker->numberBetween(1000, 1000000),
            'logoURL' => $this->faker->imageUrl(),
            'description' => $this->faker->sentence,
            'contractAddress' => $this->faker->regexify('0x[0-9a-fA-F]{40}'),
            'deployerAddress' => $this->faker->regexify('0x[0-9a-fA-F]{40}'),
        ];
    }
}
