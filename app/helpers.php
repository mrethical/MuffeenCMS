<?php

// BITS

function format_bytes($bytes, $format, $precision = 2) {
    $list_units = array('B', 'KB', 'MB', 'GB', 'TB');
    $index = array_search($format, $list_units);
    $units = array();
    if ($index)
    {
        for($i = 0; $i < count($list_units); $i++)
        {
            $units[] = $list_units[$i];
        }
    }

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= pow(1024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
}

// TIME

function timestamp_ago($timestamp, $return_empty_if_more_than_a_day = FALSE)
{
    $seconds = strtotime($timestamp);
    $seconds_now = time();
    $difference = $seconds_now - $seconds;
    if ($difference < 11) return 'Just Now';
    else if ($difference < 60) return $difference . ' seconds ago';
    else if ($difference < 120) return '1 minute ago';
    else if ($difference < 3600) return floor($difference/60) . ' minutes ago';
    else if ($difference < 7200) return '1 hour ago';
    else if ($difference < 86400) return floor($difference/3600) . ' hours ago';
    else if (!$return_empty_if_more_than_a_day)
    {
        if ($difference < 172000) return 'Yesterday';
        else return date('Y/m/d', strtotime($timestamp));
    }
    else return '';
}