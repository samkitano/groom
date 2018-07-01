<?php

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Constants
|--------------------------------------------------------------------------
|
| Application Constants
|
*/

require_once 'constants.php';

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| Application helper functions
|
*/

if (! function_exists('human_file_size')) {
    /**
     * Human readable file sizes
     *
     * @param int $sizeInBytes
     * @return string
     */
    function human_file_size(int $sizeInBytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        if ($sizeInBytes == 0) {
            return '0 ' . $units[1];
        }

        for ($i = 0; $sizeInBytes > 1024; $i++) {
            $sizeInBytes /= 1024;
        }

        return round($sizeInBytes, 2) . ' ' . $units[$i];
    }
}

if (! function_exists('humanize_diff_date')) {
    /**
     * Returns human readable difference between
     * the current date and a given past date
     *
     * @param Carbon $date
     * @return string
     */
    function humanize_diff_date(Carbon $date): string
    {
        return (new Jenssegers\Date\Date($date->timestamp))->ago();
    }
}

if (! function_exists('string_between')) {
    /**
     * http://stackoverflow.com/questions/5696412/get-substring-between-two-strings-php
     *
     * @param string $string Haystack
     * @param string $start  Search start
     * @param string $end    Search end
     *
     * @return string
     */
    function string_between($string, $start, $end): string
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);

        if ($ini == 0) {
            return '';
        }

        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;

        return substr($string, $ini, $len);
    }
}
