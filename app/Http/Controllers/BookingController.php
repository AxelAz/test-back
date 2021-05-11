<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\BookingStoreFormRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class BookingController extends Controller
{

    /**
     * Display a listing of Booking.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $bookings = $user->bookings()
                             ->orderBy('date', 'desc')
                             ->get();
            return BookingResource::collection($bookings);

        } catch (Throwable $e) {
            Log::error($e);
            return $e;
        }
    }

    /**
     * Store a newly created Booking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingStoreFormRequest $request)
    {
        try {
            $user    = Auth::user();
            $booking  = null;

            if ($user) {
                $booking = $user->bookings()->FirstOrCreate([
                    'doctor_id' => $request->input('doctor_id'),
                    'user_id'   => $user->id,
                    'date'      => $request->input('date'),
                    'status'    => Booking::STATUS_CONFIRMED,
                ]);

                $booking->save();
            }
            return new BookingResource($booking);

        } catch (Throwable $e) {
            Log::error($e);
            return $e;
        }
    }

     /**
     * Remove the specified Booking.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        try {
            $booking->cancel();

            return new BookingResource($booking);
        } catch (Throwable $e) {
            Log::error($e);
            return $e;
        }
    }

}
