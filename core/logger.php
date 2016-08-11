<?php
namespace Core;

use Monolog\Logger,
    Monolog\Handler\StreamHandler;

class Logger {
    public static function warning($name, $message) {
        self::put($name, $message, Logger::WARNING);
    }
    
    public static function error($name, $message) {
        self::put($name, $message, Logger::ERROR);
    }
    
    public static function info($name, $message) {
        self::put($name, $message, Logger::INFO);
    }
    
    public static function critical($name, $message) {
        self::put($name, $message, Logger::CRITICAL);
    }
    
    public static function debug($name, $message) {
        self::put($name, $message, Logger::DEBUG);
    }
    
    private static function put($name, $message, $type) {
        $file = date('Y-m-d') . '.log';
        $log = new Logger($name);
        $log->pushHandler(new StreamHandler(_LOG_PATH_ . '/' . $file, $type));
        
        switch($type){
            case 100:
                $log->debug($message);
                break;
            case 200:
                $log->info($message);
                break;
            case 300:
                $log->warning($message);
                break;
            case 400:
                $log->error($message);
                break;
            case 500:
                $log->critical($message);
                break;
            case 550:
                $log->alert($message);
                break;
            case 600:
                $log->emergency($message);
                break;
        }
    }
}