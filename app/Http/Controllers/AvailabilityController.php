<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AvailabilityController extends Controller {

    public function get(): Response {
        $availability = Availability::where('user_id', Auth::id())->first();
        return Inertia::render('Availability/Index', [
            'availability' => $availability,
        ]);
    }

    public function update(): void {
        $request = request()->all();
        Availability::updateOrCreate(['user_id' => Auth::id()], $request);
    }
}
