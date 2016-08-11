<?php
namespace App\Controllers;

use App\Helpers\Url,
    App\Models\Mailing,
    Core\Request,
    Core\Json,
    Core\Response,
    Core\Logger,
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
            Logger::warning(
                'SUBSCRIPTION',
                'Subscription token failed ..'
            );
            
            $this->rm->setResponse(false, 'Request not allowed');
            Json::encode( $this->rm );
            
            exit;            
        }
        
        $val = SubscriptorValidation::validate( $req );
            
        if ($val->isSuccess()) {
            $this->rm = $this->mm->add( $req );
        } else {
            $this->rm->setErrors( $val->getErrors() );
        }

        Json::encode( $this->rm );
    }
}