<?php

namespace Database\Factories;

use App\Models\Delegation;
use Illuminate\Database\Eloquent\Factories\Factory;

class DelegationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Delegation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'employee_id' => null,
            'start' => now()->subDays(5),
            'end' => now(),
            'amount_due' => 100,
            'country' => 'PL',
        ];
    }
}
