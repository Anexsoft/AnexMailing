<?php
namespace App\Controllers;

use App\Helpers\Url,
    App\Models\User,
    Core\Auth,
    Core\Request,
    Core\Response,
    SimpleValidator,
    Core\Json;

class UserController extends \Core\Controller {
    private $um,
            $rm;

    public function __CONSTRUCT() {
        if( !Auth::verify() ) {
            Url::redirect('admin');
        }

        $this->um = new User();
        $this->rm = new Response();
    }

    public function index() {
        $this->view('user/index', [
            'model' => $this->um->get( Auth::user()->id )
        ]);
    }

    public function save() {
        // Validation
        $rules = [
            'name' => ['required'],
            'nickname' => ['required'],
        ];

        $req = Request::fromBody();

        $val = SimpleValidator\Validator::validate($req, $rules);

        if ($val->isSuccess() == true) {
            $this->rm = $this->um->save( $req );
        } else {
            $this->rm->setErrors( $val->getErrors() );
        }

        Json::encode( $this->rm );
    }

    public function credentials() {
        // Validation
        $rules = [
            'email' => ['required', 'email']
        ];

        $req = Request::fromBody();

        if(!empty($req['password'])) {
            $rules['password'] = ['required', 'min_length(4)'];
        } else {
            unset($req['password']);
        }

        $val = SimpleValidator\Validator::validate($req, $rules);

        if ($val->isSuccess() == true) {
            $this->rm = $this->um->save( $req );
        } else {
            $this->rm->setErrors( $val->getErrors() );
        }

        Json::encode( $this->rm );
    }
}
