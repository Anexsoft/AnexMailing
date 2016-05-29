<?php
namespace App\Controllers;

use App\Helpers\Url,
    App\Models\Media,
    App\Models\User,
    Core\Auth,
    Core\Request,
    Core\Json;

class AdminHomeController extends \Core\Controller {
    private $um;
    
    public function __CONSTRUCT() {
        if( !Auth::verify() ) Url::redirect('admin');
        
        $this->um = new User();
    }
    
    public function index() {
        $this->view('home/index');
    }
}