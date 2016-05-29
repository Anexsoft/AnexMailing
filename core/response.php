<?php
namespace Core;

class Response
{
	public $result     = null;
	public $response   = false;
	public $message    = 'Ocurrio un error inesperado.';
    public $errors     = [];
	
	public function SetResponse($response, $m = '')
	{
		$this->response = $response;
		$this->message = $m;

		if(!$response && $m = '') $this->response = 'Ocurrio un error inesperado';
        
        return $this;
	}
}