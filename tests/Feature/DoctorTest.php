<?php

namespace Tests\Feature;

use App\Models\Doctor;
use Carbon\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorTest extends TestCase
{
    use RefreshDatabase;

    public function testICanListAllDoctors()
    {
        $doctors = Doctor::factory(2)->create();

        $this->get(
            route('doctor.index')
        )
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]
        ]);
    }

}
