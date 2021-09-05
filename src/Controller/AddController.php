<?php

namespace App\Controller;

use App\Responder\ResponderHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/add", name="add", methods={"GET"})
 */
class AddController extends AbstractController
{
    public function __invoke(
        Request $request,
        ResponderHandler $responder
    ): Response
    {
        return $responder->response(
            'add.html.twig',
            [
                'controller_name' => 'AdminController',
            ]
        );
    }
}
