<?php
namespace App\Controllers;

use App\Helpers\Url,
    App\Models\Mailing,
    App\Models\User,
    App\Validations\SubscriptorValidation,
    Core\Auth,
    Core\Request,
    Core\Response,
    Core\Json;

class SubscriptorController extends \Core\Controller {
    private $mm;
    private $rm;

    public function __CONSTRUCT() {
        if( !Auth::verify() ) {
            Url::redirect('auth');
        }

        $this->mm = new Mailing();
        $this->rm = new Response();
    }

    public function index() {
        $this->view('subscriptor/index');
    }
    
    public function get(){
        Json::encode(
            $this->mm->get(
                Request::fromBody()['id']
            )
        );
    }

    public function getAll(){
        print_r($this->mm->getAll());
    }

    public function unsubscribe() {
      $req = Request::fromBody();

      Json::encode(
        $this->mm->unsubscribe( $req['ids'] )
      );
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
    
    public function edit() {
        $req = Request::fromBody();
        $val = SubscriptorValidation::validate( $req );

        if ($val->isSuccess()) {
            $id = $req['id'];
            $data = [
                'email' => $req['email'],
                'name' => $req['name'],
                'relation' => $req['relation'],
                'inactive' => $req['inactive'],
            ];
            
            $this->rm = $this->mm->edit( $id, $data );
        } else {
            $this->rm->setErrors( $val->getErrors() );
        }

        Json::encode( $this->rm );
    }

    public function groups() {
        Json::encode( $this->mm->groups() );
    }

    public function export() {
      $req = Request::fromQueryString();
      $csvObj = new \mnshankar\CSV\CSV();

      return $csvObj->fromArray(
        $this->mm->export($req['inactive'], $req['relation'])
      )->render(
        sprintf('suscriptores-%s.csv', date('Ymdhis'))
      );
    }
}