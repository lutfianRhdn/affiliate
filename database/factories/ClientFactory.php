<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user =User::whereHas('roles',function($q){$q->where('name','reseller');})->get()->random();
        return [
            'name'=> $this->faker->name,
            'product_id'=>$user->product->id,
            'company_id'=>$user->company->id,
            'user_id'=>$user->id,
            'unic_code'=>Str::random(6),
            'company'=> $this->faker->company
        ];
    }
}
