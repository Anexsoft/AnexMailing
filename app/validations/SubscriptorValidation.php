<?php
namespace App\Validations;

use SimpleValidator;

class SubscriptorValidation {
    public static function validate($req){
        $rules = [
            'email' => [
              'required',
              'email',
              'max_length(100)'
            ],
            'name' => [
              'max_length(50)'
            ],
            'relation' => [
              'max_length(50)'
            ],
        ];

        return SimpleValidator\Validator::validate($req, $rules);
    }
}