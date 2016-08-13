<?php
namespace App\Controllers;

use App\Helpers\Url,
    App\Models\Mailing,
    Core\Request,
    Core\Json,
    Core\Response,
    Core\Log,
    Core\Token,
    App\Validations\SubscriptorValidation,
    Firebase\JWT\JWT,
    Config;

class FrontEndController extends \Core\Controller {
    private $config;
    private $mm;
    private $rm;
    
    public function __CONSTRUCT() {
        $this->config = Config::get();
        $this->mm = new Mailing();
        $this->rm = new Response();
    }
    
    public function index() {
        $this->partial('frontend/index', [
            'config' => $this->config,
            'token'  => Token::generate()
        ]);
    }
    
    public function add() {
        header('application/json');
        
        $req = Request::fromBody();
        
        if(!Token::verify(@$req['token'])){
            Log::warning(
                'SUBSCRIPTION',
                'Subscription token failed ..'
            );
            
            $this->rm->setResponse(false, 'Request not allowed');
            Json::encode( $this->rm );
            
            exit;            
        }
        
        $val = SubscriptorValidation::validate( $req );
            
        if ($val->isSuccess()) {
            $this->rm = $this->mm->add([
                'email'    => $req['email'],
                'name'     => empty($req['name']) ? '' : $req['name'],
                'relation' => empty($req['relation']) ? '' : $req['relation'],
            ]);
        } else {
            $this->rm->setErrors( $val->getErrors() );
        }

        Json::encode( $this->rm );
    }
}