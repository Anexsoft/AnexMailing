<?php
namespace App\Models;

use Core\DbContext;

class Media {
    private $db = null;
    
    public function __CONSTRUCT() {
        $this->db = DbContext::get();
    }
    
    public function get() {
        
    }
}