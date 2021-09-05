<?php

namespace App\Services\Connection;

use App\Entity\Genie;
use App\Services\SiteManager;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DatabaseConnection.
 *
 * @description
 */
class DatabaseConnection
{
    private $connection;
    private $doctrine;
    private $siteManager;
    private $params;

    public function __construct(ManagerRegistry $doctrine, SiteManager $siteManager)
    {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager();
        $this->siteManager = $siteManager;
    }

    public function connect()
    {
        $this->connection = $this->em->getConnection();
        $this->params = $this->doctrine->getManager()
            ->getConnection()->getParams();

        $this->connection->close();
    }

}
