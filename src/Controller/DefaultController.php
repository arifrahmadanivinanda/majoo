<?php

namespace App\Controller;

use App\Responder\ResponderHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="default")
 */
class DefaultController extends AbstractController
{
    public function __invoke(
        Request $request,
        ResponderHandler $responder
    ): Response
    {
        $query= "SELECT * FROM items";
        $em = $this->getDoctrine()->getManager();
        $prepare = $em->getConnection()->prepare($query);
        $prepare->execute();
        $items = $prepare->fetchAll();
        $session = $request->getSession();
        $loggedIn = false;
        if($session->get('_security_admin')){
            $loggedIn = true;
        }

        return $responder->response(
            'default.html.twig',
            [
                'loggedIn' => $loggedIn,
                'items' => $items,
                'controller_name' => 'DefaultController',
            ]
        );
    }
}
