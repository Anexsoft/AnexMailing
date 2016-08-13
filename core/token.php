<?php
namespace Core;

class Token {
    public static function generate () {
        return sha1(\Config::get()->tokenAuthSecurity . self::aud());
    }
    
    public static function verify ( $hash ) {
        $string = sha1(\Config::get()->tokenAuthSecurity . self::aud());
        return $hash === $string;
    }
    
    private static function aud() {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }
}