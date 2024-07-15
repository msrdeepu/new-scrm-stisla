<?php


/**
 * Calculate Human readable time
 */

if (function_exists('timeAgo')) {


    function timeAgo($timestamp)
    {
        $timeDifference = time() - strtotime($timestamp);
        $seconds = $timeDifference;
        $minutes = round($timeDifference / 60);
        $hours = round($timeDifference / 3600);
        $days = round($timeDifference / 86400);

        if ($seconds <= 60) {
            return "$seconds\s ago";
        } elseif ($minutes <= 60) {
            return "$minutes\s ago";
        } elseif ($hours <= 24) {
            return "$hours\h ago";
        } else {
            return date('j M Y', strtotime($timestamp));
        }
    }
}

// truncate the string
if (!function_exists('truncate')) {
    function truncate($str, $limit = 12)
    {
        return \Str::limit($str, $limit, '...');
    }
}
