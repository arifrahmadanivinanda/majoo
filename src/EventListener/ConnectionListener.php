<?php

namespace App\EventListener;

use App\Services\Connection\ConnectionHandler;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class ConnectionListener
{
    private $request;
    private $conferenceHandler;

    public function __construct(
        ConnectionHandler $conferenceHandler
    ) {
        $this->conferenceHandler = $conferenceHandler;
    }

    public function __invoke(RequestEvent $event)
    {

        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }

        $request = $event->getRequest();

        $conferenceId = ($request->get('genie')) ? $request->get('genie') : 1;
        $conferenceId = ($request->query->get('genie')) ? $request->query->get('genie') : $conferenceId;
        $conferenceId = ($request->attributes->get('genie')) ? $request->attributes->get('genie') : $conferenceId;
        $conferenceId = ($request->get('genie')) ? $request->get('genie') : $conferenceId;
        $conferenceId = ($request->headers->get('x-genie')) ? $request->headers->get('x-genie')  : $conferenceId;
        $conferenceId = ($request->attributes->get('conference')) ? $request->attributes->get('conference') : $conferenceId;

        $this->conferenceHandler->handleConnection($conferenceId);
    }
}
