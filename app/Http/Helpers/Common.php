<?php

namespace App\Http\Helpers;

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
}
