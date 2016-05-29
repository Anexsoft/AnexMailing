<?php
class Config {
    public static function get() {
        return (object)[
            
            /* Environment*/
            'environment'   => 'dev', // Options: dev, prod, stop
            
            /* Database access */
            'database' => (object)[
                'dns'  => 'mysql:host=localhost;dbname=cmsnator;charset=utf8',
                'user' => 'root',
                'pass' => ''       
            ],
            
            /* Timezone */
            'timezone'      => 'America/Lima',
            
            /* Admin area security */
            'adminAccessSecurity'      => 'asdawd56s46@w8',
            'adminTokenAuthSecurity' => 'adwpaksd.5@'
        ];       
    }
}