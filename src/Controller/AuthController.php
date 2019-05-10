<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\Session\Session;


class AuthController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session){
        $this->session = $session;
    }

    /**
     * @Route("/auth", name="auth")
     */

    public function index()
    {   
        $this->session->set('user','admin');

        $user = $this->session->get('user');

        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
            'userName' => $user
        ]);
    }

    /**
     * @Route("/isauth", name="isauth")
     */

    public function isAuth(){

        $session = new Session();
        $session->setName('auth');

        $session->start();

        if($session->has('user')){
            $user = "Daredevil";
        }else{
            $session->set('user','lukas');
            $user = $session->get('user');
        }

        $session->remove('user');



        //$session->remove('auth');
        



        

        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
            'userName' => $user
        ]);

    }


}
