<?php

namespace App\Controller;

use App\Responder\ResponderHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin", methods={"GET"})
 */
class AdminController extends AbstractController
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
        return $responder->response(
            'admin.html.twig',
            [
                'items' => $items,
                'controller_name' => 'AdminController',
            ]
        );
    }
}
