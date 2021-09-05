<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

class SiteManager
{
    private $request;
    private $kernel;
    private $router;
    const CENTRALS = array('as1','as2','as3'); 

    function __construct(RequestStack $request, RouterInterface $router)
    {
        $this->request = $request;
        $this->router = $router;
    }
}
