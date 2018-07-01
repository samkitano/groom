<?php

use App\Kitano\Exceptions\ConstantDefinedException;

if (! defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
} else {
    throw new ConstantDefinedException("Constant 'DS' is already defined with value = ".DS);
}

if (! defined('ZIP_EXTENSION')) {
    define('ZIP_EXTENSION', '.zip');
} else {
    throw new ConstantDefinedException("Constant 'ZIP_EXTENSION' is already defined with value = ".ZIP_EXTENSION);
}

if (! defined('LOG_EXTENSION')) {
    define('LOG_EXTENSION', '.log');
} else {
    throw new ConstantDefinedException("Constant 'LOG_EXTENSION' is already defined with value = ".LOG_EXTENSION);
}

if (! defined('LOG_PREFIX')) {
    define('LOG_PREFIX', 'laravel-');
} else {
    throw new ConstantDefinedException("Constant 'LOG_PREFIX' is already defined with value = ".LOG_PREFIX);
}
