<?php
namespace Core;

class Response
{
	public $result     = null;
	public $response   = false;
	public $message    = 'Ocurrio un error inesperado.';
	public $href       = null;
    public $errors     = null;

	public function setResponse($response, $m = '') {
		$this->response = $response;
		$this->message = $m;

		if(!$response && $m = '') $this->response = 'Ocurrio un error inesperado';

        return $this;
	}

    public function setErrors($errors) {
        $this->response = false;
        $this->message = 'La validación no ha sido superada';
	    $this->errors = $errors;

	    return $this;
    }
}