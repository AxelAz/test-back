<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('now', '+1 month');


        return [
            'user_id' => 1,
            'doctor_id' => 1,
            'date' => $date,
            'status' => Booking::STATUS_CONFIRMED,
        ];
    }
}
