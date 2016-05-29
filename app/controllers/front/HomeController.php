<?php
namespace App\Controllers;

class HomeController extends \Core\Controller {
    public function __CONSTRUCT() {
        
    }
    
    public function index() {
        $this->view('home/index', [
            'model' => 1
        ]);
    }
    
    public function home(){
        echo 'home';
    }
}