<?php
namespace App\Models;

use Core\DbContext,
    Core\Auth,
    Core\Response,
    Core\Crypt;

class User {
    private $db = null;
    private $rm = null;
    private $table = 'user';
    
    public function __CONSTRUCT() {
        $this->db = DbContext::get();
        $this->rm = new Response();
    }
    
    public function signIn($email, $password) {
        $user = $this->db
                     ->from('user')
                     ->select('id,role_id,name,nickname,email')
                     ->where([
                         'email' => $email
                     ])->fetch();
        
        if(is_object( $user )) {
            if( Crypt::verify($password, $user->password) ) {
                Auth::signIn( $user );
                $this->rm->setResponse(true);
            } else {
                $this->rm->setResponse(false, 'Acceso denegado');
            }
        } else {
            $this->rm->setResponse(false, 'Acceso denegado');
        }
        
        return $this->rm;
    }
}