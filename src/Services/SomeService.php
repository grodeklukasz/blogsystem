<?php
namespace App\Services;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SomeService{

    private $session;

    public function __construct(){
        

        $this->session = new session();

    }

    public function setSessionName(){
        
        $this->session->set('name', 'lukas');

    }

    public function getSessionName(){
        
        return $this->session->get('name');
    
    }

}

?>
