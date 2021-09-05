<?php

namespace App\Controller;

use App\Responder\ResponderHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @Route("/add_process", name="add_process", methods={"POST"})
 */
class AddProcessController extends AbstractController
{
    public function __invoke(
        Request $request,
        ResponderHandler $responder
    ): Response
    {
        $requestForm = $request->request->all();
        $id = $requestForm['id'];
        $name = $requestForm['name'];
        $price = $requestForm['price'];
        $description = $requestForm['description'];
        $image = $request->files->get('image');

        $file =  new File($image);
        $target_dir = $this->getParameter('kernel.project_dir') . '/public/img/uploads/';
        $filename = $name.'_'.$price.'.'.$file->guessExtension();
        $target_file = $target_dir . $filename;
        $file->move($target_dir, $target_file);

        $query= "INSERT INTO items (name, price, description,image) VALUES ('$name','$price','$description','$filename')";
        $em = $this->getDoctrine()->getManager();
        $prepare = $em->getConnection()->prepare($query);
        $prepare->execute();
        echo"<script language='javascript'>";
        echo("window.opener.location.href = '/admin';");
        echo("window.close();");
        echo "</script>";
        return new JsonResponse();
    }
}
