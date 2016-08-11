<?php
namespace App\Controllers;

use Config,
    App\Helpers\Url;

class TestController extends \Core\Controller {
    
    public function index() {
        $config = Config::get();
        
        if($config->environment === 'prod') {
            Url::redirect('');
        }
        
        $this->view('test/index', [
            'config' => $config
        ]);
    }
}