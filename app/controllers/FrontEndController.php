<?php
namespace App\Controllers;

use App\Helpers\Url,
    App\Models\Mailing,
    Core\Request,
    Core\Json,
    Core\Response,
    App\Validations\SubscriptorValidation,
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
            'config' => $this->config
        ]);
    }
    
    public function add() {
        $req = Request::fromBody();
        $val = SubscriptorValidation::validate( $req );
            
        if ($val->isSuccess()) {
            $this->rm = $this->mm->add( $req );
        } else {
            $this->rm->setErrors( $val->getErrors() );
        }

        Json::encode( $this->rm );
    }
}