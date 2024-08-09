<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rules;
use Inertia\Response;

class AvailabilityController extends Controller {

    public function get(): Response {
        $availability = Availability::where('user_id', Auth::id())->get();

        return Inertia::render('Availability/Index', [
            'availability' => $availability,
        ]);
    }

    public function update(Request $request): RedirectResponse {
        $request->validate([
            'name' => 'required|string|max:255',
            'middle_name' => 'string|max:255|nullable',
            'last_name' => 'string|max:255|nullable',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('student');
    }

}
