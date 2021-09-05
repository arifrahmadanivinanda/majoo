<?php

namespace App\Controller;

use App\Responder\ResponderHandler;
use App\Security\Encryptor;
use App\Services\AuthRedirectService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auth", name="auth")
 */
class AuthController extends AbstractController
{
    private $authRedirectServ;

    public function __construct(AuthRedirectService $authRedirectServ)
    {
        $this->authRedirectServ = $authRedirectServ;
    }

    public function __invoke(
        Request $request,
        ResponderHandler $responder
    ): Response
    {
        $firewall = 'admin';
        $requestForm = $request->request->all();
        $username = $requestForm['username'];
        $password = $requestForm['password'];

        $query= "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $em = $this->getDoctrine()->getManager();
        $prepare = $em->getConnection()->prepare($query);
        $prepare->execute();
        $login = $prepare->fetchAll();

        if ($login) {
            # set token
            $token = new PreAuthenticatedToken($requestForm['username'], $requestForm['username'], 'admin', array('ROLE_ADMIN'));
            $this->get('security.token_storage')->setToken($token);

            $session = new Session();
            $session->set('_security_' . $firewall, serialize($token));
            
            $redirectUrl = $this->authRedirectServ
                ->getRedirectUrl(
                    $request,
                    'admin'
                );

            return $this->redirect($redirectUrl);
        } else {
            return $responder->response(
                'login.html.twig',
                [
                    'alert' => 'Login gagal!',
                    'controller_name' => 'LoginController',
                ]
            );
        }
    }
}
