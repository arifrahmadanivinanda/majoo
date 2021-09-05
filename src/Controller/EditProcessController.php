<?php

namespace App\Controller;

use App\Responder\ResponderHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
/**
 * @Route("/edit_process", name="edit_process", methods={"POST"})
 */
class EditProcessController extends AbstractController
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
        if($image){
            $file =  new File($image);
            $target_dir = $this->getParameter('kernel.project_dir') . '/public/img/uploads/';
            $filename = $name.'_'.$price.'.'.$file->guessExtension();
            $target_file = $target_dir . $filename;
            $file->move($target_dir, $target_file);
            $query= "UPDATE items SET name = '$name', price = '$price', description = '$description', image = '$filename' WHERE id = '$id'";
        }else{
            $query= "UPDATE items SET name = '$name', price = '$price', description = '$description' WHERE id = '$id'";
        }
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
