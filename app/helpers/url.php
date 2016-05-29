<?php
namespace App\Helpers;

class Url {
    public static function getBase($route = '') {
        return _BASE_HTTP_ . $route;
    }
    
    public static function getAsset($route = '') {
        return _BASE_HTTP_ . 'assets/' . $route;
    }
    
    public static function toFriendly($text) {
        if (empty($text)) {
            throw new Exception('You entered an empty string');
        }
        
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        return $text;
    }
    
    public static function redirect($url = ''){
        header(sprintf("Location: %s%s", _BASE_HTTP_, $url));
    }
}