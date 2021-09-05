<?php

namespace App\Controller;

use App\Responder\ResponderHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/edit/id/{id}", name="edit", methods={"GET"})
 */
class EditController extends AbstractController
{
    public function __invoke(
        Request $request,
        ResponderHandler $responder
    ): Response
    {
        $id = $request->attributes->get('id');
        $query= "SELECT * FROM items WHERE id = $id";
        $em = $this->getDoctrine()->getManager();
        $prepare = $em->getConnection()->prepare($query);
        $prepare->execute();

        $items = $prepare->fetchAll();
        return $responder->response(
            'edit.html.twig',
            [
                'items' => $items,
                'controller_name' => 'AdminController',
            ]
        );
    }
}
