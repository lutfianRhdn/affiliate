<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'total_payment'=> rand(1,9) . '0000',
            'payment_date'=> $this->faker->dateTimeBetween('-5 years','now'),
            'status'=>rand(0,1),
            'client_id'=>Client::all()->random()->id
        ];
    }
}
