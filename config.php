<?php
class Config {
    public static function get() {
        return (object)[
            /* Environment*/
            'environment'   => 'dev', // Options: dev, prod, stop

            /* Database access */
            'database' => (object)[
                'dns'  => 'mysql:host=localhost;dbname=anexmailing;charset=utf8',
                'user' => 'root',
                'pass' => ''
            ],

            /* Timezone */
            'timezone' => 'America/Lima',

            /* Auth */
            'tokenAuthSecurity' => 'adwpaksd.5@',

            /* Trusted Email Domains */
            'trustedDomain' => ['hotmail', 'outlook', 'gmail', 'yahoo', 'live'],
            
            /* Start Year */
            'startYear' => 2016,

            /* Software credit */
            'productName' => 'AnexMailing',
            'productVersion' => '1.1b',
            
            /* Test file enabled */
            'testEnabled' => true
        ];
    }
}
