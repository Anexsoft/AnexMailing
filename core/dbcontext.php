<?php
namespace Core;

use PDO;

class DbContext {
    private static $db = null;
    
    public static function get() {
        if(empty(self::$db)) {
            $config = \Config::get();
            
            $pdo = new PDO($config->database->dns, $config->database->user, $config->database->pass);

            if($config->environment === 'dev') {
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);                
            }
            
            self::$db = new \FluentPDO($pdo);            
        }
       
        return self::$db;
    }
}