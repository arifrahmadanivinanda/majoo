<?php

namespace App\Controller;

use App\Responder\ResponderHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/delete_process/{id}", name="delete_process", methods={"GET"})
 */
class DeleteProcessController extends AbstractController
{
    public function __invoke(
        Request $request,
        ResponderHandler $responder
    ): Response
    {
        $id = $request->attributes->get('id');
        $query= "DELETE FROM items WHERE id = '$id'";
        $em = $this->getDoctrine()->getManager();
        $prepare = $em->getConnection()->prepare($query);
        $prepare->execute();
        echo"<script language='javascript'>";
        echo("window.opener.location.href = '/admin';");
        echo("window.close();");
        echo "</script>";
        return new Response();
    }
}
