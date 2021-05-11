<?php

namespace App\Http\Controllers;

use App\Http\Requests\Availability\AvailabilityFormRequest;
use App\Http\Resources\AvailabilityResource;
use App\Models\Availability;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {
            $doctor = Doctor::findOrFail($id);

            if ($doctor->agenda === Doctor::AGENDA_DATABASE) {
                return AvailabilityResource::collection($doctor->availabilities()->get());
            }

            $externalAvailabilities = Http::get(config('agenda.' . $doctor->agenda) . $doctor->external_agenda_id)->collect();

            $availabilities = $externalAvailabilities->map(function($externalAvailability) use ($doctor){
                return $doctor->availabilities()->firstOrNew([
                    'start' => $externalAvailability['start'],
                ]);
            });


            return AvailabilityResource::collection($availabilities);

        } catch (Throwable $e) {
            Log::error($e);
            return $e;
        }
    }
}
