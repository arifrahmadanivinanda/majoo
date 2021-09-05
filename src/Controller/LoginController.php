<?php

namespace App\Controller;

use App\Responder\ResponderHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/login", name="login")
 */
class LoginController extends AbstractController
{
    public function __invoke(
        Request $request,
        ResponderHandler $responder
    ): Response
    {
        $session = $request->getSession();
        $loggedIn = false;
        if($session->get('_security_admin')){
            $loggedIn = true;
        }
        if($loggedIn){
            header('Location: /admin');
            return new Response();
        }else{
            return $responder->response(
                'login.html.twig',
                [
                    'alert' => '',
                    'controller_name' => 'LoginController',
                ]
            );
        }
    }
}
