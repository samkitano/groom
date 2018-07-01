<?php

namespace App\Kitano\Helpers;

class RegexPatterns
{
    const LOG_DATE_PATTERN = '[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]';
    const DATE_PATTERN = '\d{4}(-\d{2}){2}';
    const TIME_PATTERN = '\d{2}(:\d{2}){2}';
    const LOGS_PATTERN = '*.log';
    const ZIPS_PATTERN = '*.zip';
}
