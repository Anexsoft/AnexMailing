<?php
namespace App\Controllers;

use App\Helpers\Url,
    Config;

class ExampleController extends \Core\Controller {
    public function __CONSTRUCT(){
        $config = Config::get();

        if(!$config->environment === 'prod') {
            Url::redirect('');
        }
    }
    public function index() {
        $this->partial('example/index');
    }

    public function two() {
        $this->partial('example/two');
    }
}