<?php
namespace Core;

class Request {
    public static function get() {
        $bodyData = [];
        
        $bodyData = self::sanitize( $_REQUEST );
        
        return $bodyData;
    }
    
    public static function sanitize( $data ){
        foreach($data as $k => $r) {
            if(is_array($r)) {
                $data[$k] = self::sanitize ( $data[$k] );
            } else {
                $data[$k] = trim($r);
            }
        }
        
        return $data;
    }
}