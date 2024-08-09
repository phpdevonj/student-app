<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AvailabilityController extends Controller {

    public function get(): Response {
        $availability = Availability::where('user_id', Auth::id())->get();

        return Inertia::render('Availability/Index', [
            'availability' => $availability,
        ]);
    }

}
