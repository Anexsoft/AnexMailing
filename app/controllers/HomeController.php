<?php
namespace App\Controllers;

use App\Helpers\Url,
    App\Models\Mailing,
    Core\Auth,
    SimpleValidator,
    Core\Request,
    Core\Response,
    Core\Json;

class HomeController extends \Core\Controller {
    private $mm;
    
    public function __CONSTRUCT() {
        if( !Auth::verify() ) {
            Url::redirect('auth');
        }

        $this->mm = new Mailing();
    }
    
    public function index() {
        $this->view('home/index');
    }
    
    public function landing(){
        Json::encode(
            $this->mm->landing()
        );
    }
    
    public function chart(){
        Json::encode(
            $this->mm->chart()
        );
    }
}