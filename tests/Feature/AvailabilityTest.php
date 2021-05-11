<?php

namespace Tests\Feature;

use App\Models\Availability;
use App\Models\Doctor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AvailabilityTest extends TestCase
{
    use RefreshDatabase;

    public function testICanListAvailabilities()
    {
        Doctor::factory(2)->hasAvailabilities(10)->create();;
        Doctor::factory(2)->withAgenda(Doctor::AGENDA_DOCTOLIB)->create();
        Doctor::factory(2)->withAgenda(Doctor::AGENDA_CLICRDV)->create();

        $this->get(
            route('availability.index', ['id' => 4]))
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'start',
                ]
            ]
        ]);
    }
}
