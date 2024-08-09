<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleMember;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Validation\Rules;
use Inertia\Response;

class ScheduleController extends Controller {

    public function list(): Response {
        $schedules = Schedule::paginate(10);

        $students = User::all();

        return Inertia::render('Schedule/Index', [
            'schedules' => $schedules,
            'students' => $students,
        ]);
    }

    public function store(Request $request): RedirectResponse {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date_time' => 'date|max:255|required',
            'end_date_time' => 'date|max:255|required',
            'students.*' => 'required|exists:users,id',
        ]);

        // TODO: Check max difference of 15 min only
        // TODO: Check students.* should not be already in schedules
//        then return value error

        $status = 'Something went wrong';
        try {
            DB::beginTransaction();
            if ($request->students) {
                $schedule = Schedule::create([
                    'title' => $request->title,
                    'start_date_time' => $request->start_date_time,
                    'end_date_time' => $request->end_date_time
                ]);
                foreach ($request->students as $students) {
                    ScheduleMember::create([
                        'schedule_id' => $schedule->id,
                        'user_id' => $students
                    ]);
                }
                $status = 'Schedule created';
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
        return redirect()->route('schedules')->with('status', $status);
    }

}
