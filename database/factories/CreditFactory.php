<?php

namespace Database\Factories;

use App\Models\Credit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CreditFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Credit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $payment = [
            'ABA Bank Transfer',
            'Wing',
        ];
        return [
            'username'=> 'sear007',
            'requestId'=> Str::random(10),
            'payment'=> 'Wing',
            'credit'=> 0.00,
            'beforeCredit'=> 0.00,
            'outStandingCredit'=> rand(-100,1000),
            'freeCredit'=> rand(20,50),
            'rollover'=>30,
            'lastPayment'=>$payment[rand(0,1)],
            'transaction'=> Str::random(9),
            'status'=> false,
        ];
    }
}
