<?php

namespace App\Services;

use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AuthRedirectService
{
    const DEFAULT_ROUTER = "default";
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getRedirectUrl(Request $request, string $route, int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH): string
    {
        switch ($route) {
            case 'admin' :
                return $this->container->get('router')->generate('admin');
            default:
                return $this->container->get('router')->generate(self::DEFAULT_ROUTER);
        }
    }
}