<?php

namespace App\Console\Commands;

use App\Http\Helpers\Common;
use App\Models\Schedule;
use Illuminate\Console\Command;

class ScheduleNotification extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduleNotify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {

        $now = new \DateTime();
        $sendStartTime = $now->format('Y-m-d H:i:s');

        $modified = $now->modify('+10 minutes');
        $sendEndTime = $modified->format('Y-m-d H:i:s');

        $schedules = Schedule::whereBetween('start_date_time', [$sendStartTime, $sendEndTime])->get();

        foreach ($schedules as $schedule) {
            $members = $schedule->getScheduleMembers;
            foreach ($members as $member) {
                $email = $member->getUser->email ?? null;
                if (!$email) {
                    continue;
                }
                Common::sendMail($email, 'mail.scheduleNotify', compact('schedule'));
            }
        }
        return COMMAND::SUCCESS;
    }
}
