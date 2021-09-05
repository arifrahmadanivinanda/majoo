<?php

namespace App\Services\Connection;

use App\Services\SiteManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ConnectionHandler
{
    private $dbconn;

    public function __construct(
        DatabaseConnection $dbconn
    )
    {
        $this->dbconn = $dbconn;
    }

    public function handleConnection()
    {
        $this->dbconn->connect();
    }

}
