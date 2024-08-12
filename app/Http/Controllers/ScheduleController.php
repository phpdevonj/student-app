<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Helpers\Common;
use App\Models\ScheduleMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class ScheduleController extends Controller {

    public function list(): Response {
        $schedules = Schedule::paginate(10);

        $students = User::where('type', 0)->get();

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
            'students' => 'required|array|exists:users,id',
        ]);


        $startDateTime = new \DateTime($request->start_date_time);
        $endDateTime = new \DateTime($request->end_date_time);
        $isValidDate = Common::isWithin15Minutes($startDateTime, $endDateTime);
        // Check max difference of 15 min only
        if (!$isValidDate) {
            $request->validate(['end_date_time' => 'max:1|required'], [
                'end_date_time.max' => 'Date difference must be max 15 min.',
            ]);
        }


        $isInOtherSchedule = Schedule::whereHas('getScheduleMembers', function ($query) use ($request) {
            return $query->whereIn('user_id', $request->students);
        })
            ->where(function ($query) use ($request, $startDateTime, $endDateTime) {
                return $query->where(function ($query) use ($request, $startDateTime, $endDateTime) {
                    return $query->where('start_date_time', '<=', $startDateTime)->where('end_date_time', '>=', $startDateTime);
                })->orWhere(function ($query) use ($request, $endDateTime, $startDateTime) {
                    return $query->where('start_date_time', '<=', $endDateTime)->where('end_date_time', '>=', $endDateTime);
                });
            })
            ->count();


        if ($isInOtherSchedule) {
            $request->validate(['students' => 'array|max:0|required'], [
                'students.max' => 'Some students are already in another schedule with given time.',
            ]);
        }

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

    public function view(Request $request, $id): Response {
        $schedule = Schedule::with('getScheduleMembers.getUser')->find($id);
        return Inertia::render('Schedule/View', [
            'schedule' => $schedule,
        ]);
    }

    public function rating(Request $request, $id, $user_id) {
        $request->validate(['rating' => 'required|numeric|min:1|max:10']);
        ScheduleMember::where(['schedule_id' => $id, 'user_id' => $user_id])->update(['rating' => $request->rating]);
    }

}
