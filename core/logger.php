<?php
namespace Core;

use Monolog\Logger,
    Monolog\Handler\StreamHandler;

class Logger {
    public static function warning($name, $message) {
        $file = date('Y-m-d') . '.log';
        
        $log = new Logger($name);
        $log->pushHandler(new StreamHandler(_LOG_PATH_ . '/' . $file, Logger::WARNING));
        $log->error($message);
    }
}