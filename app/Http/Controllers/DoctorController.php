<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Support\Facades\Log;
use Throwable;

class DoctorController extends Controller
{
    /**
     * Display a listing of doctors.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return DoctorResource::collection(Doctor::all());

        } catch (Throwable $e) {
            Log::error($e);
            return $e;
        }
    }
}
