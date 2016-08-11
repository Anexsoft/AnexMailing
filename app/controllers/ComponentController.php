<?php
namespace App\Controllers;

use App\Helpers\Url,
    App\Models\User,
    Core\Auth,
    Core\Request,
    Core\Json;

class ComponentController extends \Core\Controller {
    public function __CONSTRUCT() {
        if( !Auth::verify() ) {
            Url::redirect('auth');
        }
    }

    public function index() {
        $component = Request::fromQueryString()['c'];
        $this->partial("component/$component.php");
    }
}
