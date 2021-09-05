<?php

namespace App\Security;

/*
 * taken from http://symfony.com/doc/current/cookbook/security/api_key_authentication.html
 */

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected $entityManager;

    public function getUserByG5MID($g5mid)
    {
        $encryptor = new Encryptor();
        $secretText = $encryptor->decrypt($g5mid);
        $userParam = explode(':~:', $secretText);
        $userId = $userParam[0];
        $user = $this->entityManager->getRepository(User::class)->find($userId);

        return $user;
    }

    //not used.. for now (cant delete this because the interface needed this)
    public function loadUserByUsername($username)
    {

        return $this->getUserByG5MID($username);
    }

    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    public function supportsClass($class)
    {
        return 'App\Entity\User' === $class;
    }
}
