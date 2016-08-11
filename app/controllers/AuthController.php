<?php
namespace App\Controllers;

use App\Helpers\Url,
    App\Models\User,
    Core\Auth,
    Core\Request,
    Core\Json,
    Core\Response,
    SimpleValidator,
    Config;

class AuthController extends \Core\Controller {
    private $um,
            $rm,
            $gump;
    
    public function __CONSTRUCT() {
        $this->um = new User();
        $this->rm = new Response();
    }
    
    public function index() {
        if( Auth::verify() ) {
            Url::redirect('home');
        }
        
        $this->view('auth/index');
    }
    
    public function signin() {
        // Validation
        $rules = [
            'email' => [
                'required',
                'email'
            ],
            'password' => [
                'required'
            ]
        ];
        
        $req = Request::get();
        
        $val = SimpleValidator\Validator::validate($req, $rules);
        
        if ($val->isSuccess()) {
            $this->rm = $this->um->signIn( $req['email'], $req['password'] );
            if($this->rm->response) {
                $this->rm->href = 'home';
            }
        } else {
            $this->rm->setErrors( $val->getErrors() );
        }
        
        Json::encode( $this->rm );
    }
    
    public function logout() {
        Auth::destroy();
        Url::redirect('');
    }
}