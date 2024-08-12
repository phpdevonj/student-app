<?php

namespace App\Http\Helpers;

use App\Mail\SendMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Common {
    public static function isWithin15Minutes(\DateTime $datetime1, \DateTime $datetime2) {
        // Calculate the difference between the two datetimes
        $interval = $datetime1->diff($datetime2);

        // Check if the difference is more than 15 minutes
        if ($interval->days > 0 || $interval->h > 0 || $interval->i > 15) {
            return false;
        }
        return true;
    }


    /**
     * @param $to
     * @param $view
     * @param $data
     * @return bool
     */
    public static function sendMail($to, $view, $data) {
        try {
            Mail::to($to)->send(new SendMail($view, $data));
            return true;
        } catch (\Exception $ex) {
            if (env('APP_DEBUG')) {
                Log::error($ex->getMessage());
            }
            return false;
        }
    }


}
