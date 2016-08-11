<?php
namespace Core;

class Token {
    public static function generate () {
        $string = \Config::get()->tokenAuthSecurity . self::aud();
        return password_hash( $string, PASSWORD_DEFAULT );
    }
    
    public static function verify ( $hash ) {
        $string = \Config::get()->tokenAuthSecurity . self::aud();
        return password_verify ($string, $hash);
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