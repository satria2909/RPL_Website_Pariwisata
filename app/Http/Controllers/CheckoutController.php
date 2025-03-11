<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class CheckoutController extends Controller
{
    public function show($id)
        {
            $booking = Booking::findOrFail($id);
            return view('checkout', compact('booking'));
        }
}