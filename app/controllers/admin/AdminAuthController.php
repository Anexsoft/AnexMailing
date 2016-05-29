<?php
namespace App\Controllers;

use App\Helpers\Url,
    App\Models\Media,
    App\Models\User,
    Core\Auth,
    Core\Request,
    Core\Json;

class AdminAuthController extends \Core\Controller {
    private $um;
    
    public function __CONSTRUCT() {
        $this->um = new User();
    }
    
    public function index() {
        $this->view('auth/index');
    }
    
    public function signin(){
        $req = Request::get();
        $rm = $this->um->signIn( $req['email'], $req['password'] );
        
        if($rm->response) $rm->href = 'admin/home';
        
        Json::encode( $rm );
    }
}