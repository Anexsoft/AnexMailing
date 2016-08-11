<?php
namespace App\Controllers;

use App\Helpers\Url,
    Config;

class ExampleController extends \Core\Controller {
    public function index() {
        $config = Config::get();
        
        if(!$config->environment === 'prod') {
            Url::redirect('');
        }
        
        $this->partial('example/index');
    }
}