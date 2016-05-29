<?php
namespace Core;

use Firebase\JWT\JWT,
    Exception,
    Config;

class Auth
{
    private static $encrypt = array('HS256');
    private static $aud = null;
    private static $minutes = 60;
    private static $cookieName = 'user-data';
    private static $token;
    
    public static function signIn($data) {
        $time = time() + ( 60 * self::$minutes);
        
        $token = array(
            'exp'  => $time,
            'aud'  => self::Aud(),
            'data' => $data
        );
        
        $token = JWT::encode($token, Config::get()->adminTokenAuthSecurity);
        
        setcookie( self::$cookieName, $token, $time, '/' );
    }
    
    public static function verify() {
        try{
            if(empty($_COOKIE[self::$cookieName])) throw new Exception("Invalid user logged in.");
            
            $decode = JWT::decode(
                $_COOKIE[self::$cookieName],
                Config::get()->adminTokenAuthSecurity,
                self::$encrypt
            );

            if($decode->aud !== self::aud()) throw new Exception("Invalid user logged in.");
        } catch (\Exception $e) {
            return false;
        }
        
        return true;
    }
    
    public static function user() {
        if(self::isLoggedIn()){
            return JWT::decode(
                $_COOKIE[self::$cookieName],
                Config::get()->adminTokenAuthSecurity,
                self::$encrypt
            )->data;            
        }
        
        return null;
    }
    
    public static function destroy() {
        if(empty($_COOKIE[self::$cookieName])) return;
        unset( $_COOKIE[self::$cookieName] );
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