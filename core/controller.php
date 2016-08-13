<?php
namespace Core;

use Core\Router,
    Core\Log;

class Controller {
    protected $layout = 'layout';
    private $content;
    private $section = [];
    private $data = [];
    
    private $basePath = 'views/';
    
    /* Views */
    protected function partial($file, $data = []){
        // Pass data to the view
        extract($data);
        
        // Load View
        require_once _APP_PATH_ . sprintf($this->basePath . '%s.php', str_replace('.php', '', $file));
    }
    
    
    protected function view($file, $data = []){
        // Pass data to the view
        $this->data = $data;
        
        // Load View
        $this->content = _APP_PATH_ . sprintf($this->basePath . '%s.php', str_replace('.php', '', $file));
        
        // Load Layout
        require_once _APP_PATH_ . sprintf($this->basePath . $this->layout . '.php');
    }
    
    private function render() {
        extract( $this->data );
        require_once $this->content;
    }
    
    /* Sections */
    protected function setSection($key, $content) {
        $this->section[$key] = $content;
    }
    
    protected function section($key) {
        if(empty($this->section[$key])) return;
        
        return $this->section[$key] ();
    }
    
    /* Error pages */
    public function error404() {
        header("HTTP/1.0 404 Not Found");
        require_once _APP_PATH_ . $this->basePath . 'error/404.php';
        
        Log::error(
            'ROUTE',
            sprintf('Current route: [%s] not founded in server.', Router::$currentRoute)
        );
        
        exit;
    }
}