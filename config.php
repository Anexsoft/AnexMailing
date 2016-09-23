<?php
class Config {
    public static function get() {
        return (object)[
            /* Database access */
            'database' => (object)[
                'dns'  => 'mysql:host=localhost;dbname=anexmailing;charset=utf8',
                'user' => 'root',
                'pass' => ''
            ],
            
            /* Users */
            'users' => [
                ['name' => 'Anexsoft', 'email' => 'demo@anexmailing.com', 'password' => '123456'],
                ['name' => 'Eduardo', 'email' => 'erodriguezp105@gmail.com', 'password' => '123456'],
            ],
            
            /* Environment*/
            'environment' => 'dev', // Options: dev, prod, stop

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
            'productVersion' => '1.1b'
        ];
    }
}
