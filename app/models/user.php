<?php
namespace App\Models;

use Core\DbContext,
    Core\Auth,
    Core\Response,
    Config;

class User {
    private $db = null;
    private $rm = null;
    private $table = 'am_user';
    
    public function __CONSTRUCT() {
        $this->db = DbContext::get();
        $this->rm = new Response();
    }
    
    public function save($data) {
        if(isset($data['password'])) {
           if(empty($data['password'])) {
               unset($data['password']);
           } else {
               $data['password'] = Crypt::encrypt($data['password']);
           }
        }
        
        if(!empty($data['id'])) {
            $id = $data['id'];
            
            unset( $data['id'] );
            
            $this->db->update($this->table, $data, $id)
                     ->execute();
        }
        
        return $this->rm->setResponse(true);
    }
    
    public function get($id){
        return $this->db->from($this->table, $id)
                    ->fetch();
    }
    
    // Without database
    public function signIn($email, $password) {
        $user = null;
        
        foreach(Config::get()->users as $u) {
            if($u['email'] === $email && $u['password']) {
                $user = (object)$u;
                break;
            }
        }
        
        if(is_object( $user )) {
            Auth::signIn(
                (object) [
                    'name' => $user->name,
                    'email' => $user->email,
                    'last_login' => date('Y-m-d h:i:s'),
                ]
            );

            $this->rm->setResponse(true);
        } else {
            $this->rm->setResponse(false, 'Acceso denegado');
        }
        
        return $this->rm;
    }
    
    // With database
//    public function signIn($email, $password) {
//        $user = $this->db
//                     ->from($this->table)
//                     ->where([
//                         'email' => $email,
//                         'is_active' => 1
//                     ])->fetch();
//        
//        if(is_object( $user )) {
//            if( Crypt::verify($password, $user->password) ) {
//                Auth::signIn(
//                    (object) [
//                        'id' => $user->id,
//                        'name' => $user->name,
//                        'nickname' => $user->nickname,
//                        'email' => $user->email,
//                        'last_login' => $user->last_login,
//                    ]
//                );
//                
//                $this->db->update($this->table, ['last_login' => Carbon::now()], $user->id)
//                         ->execute();
//                
//                $this->rm->setResponse(true);
//            } else {
//                $this->rm->setResponse(false, 'Acceso denegado');
//            }
//        } else {
//            $this->rm->setResponse(false, 'Acceso denegado');
//        }
//        
//        return $this->rm;
//    }
}