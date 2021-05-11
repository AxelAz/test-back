<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Doctor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function testICanListAllBookings()
    {
        $user = User::factory()->hasBookings(2)->create();

        $this->actingAs($user)
            ->get(
                route('booking.index')
            )
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'doctor_id',
                        'user_id',
                        'date',
                        'status',
                    ]
                ],
            ]);
    }

    public function testICanCreateABooking()
    {
        $user = User::factory()->create();
        Doctor::factory()->create();

        $this->actingAs($user)
            ->post(
                route('booking.store'),
                [
                    'doctor_id' => 1,
                    'date'      => Carbon::parse('now'),
                ]
            )
            ->assertOk(200);
    }

    public function testICanCancelABooking()
    {
        $user = User::factory()->hasBookings(2)->create();


        $this->actingAs($user)
            ->get(
                route('booking.destroy', ['id' => 1])
            )
            ->assertOk()
            ->assertJson([
                'data' => [
                    'status' => Booking::STATUS_CANCELED,
                ],
            ]);
    }
}
