<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;

class BookingController extends Controller
{
    public function store(BookingRequest $request)
    {
        $booking = Booking::create($request->validated());

        return redirect()->route('checkout', $booking->id);
    }
}
