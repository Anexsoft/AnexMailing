<?php
namespace App\Controllers;

use App\Helpers\Url,
    Core\Auth,
    Config;

class ExampleController extends \Core\Controller {
    public function __CONSTRUCT(){
        if( !Auth::verify() ) {
            Url::redirect('auth');
        }
    }
    public function index() {
        $this->partial('example/index');
    }

    public function two() {
        $this->partial('example/two');
    }
}