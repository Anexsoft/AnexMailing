<?php
namespace Core;

class Request {
    public static function get() {
        $data = [];

        $data = self::sanitize( $_REQUEST );

        return $data;
    }

    public static function fromBody() {
        $data = [];

        $data = self::sanitize( $_POST );

        return $data;
    }

    public static function fromQueryString() {
        $data = [];

        $data = self::sanitize( $_GET );

        return $data;
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

    public static function isAjax() {
      return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }
}
