<?php

namespace User\Auth;

use Doctrine\ORM\EntityManager;
use User\Assets\SessionNamespace;
use User\Entity\User;
use User\Repository\UserRepository;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Session\Container;

/**
 * Class Adapter
 * @package User\Auth
 */
class Adapter implements AdapterInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var int
     */
    private $ttl;

    /**
     * Adapter constructor.
     * @param EntityManager $entityManager
     * @param int $ttl
     */
    public function __construct(EntityManager $entityManager, $ttl = 3600)
    {
        $this->entityManager = $entityManager;
        $this->ttl = $ttl;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param $username
     *
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function authenticate()
    {
        /** @var UserRepository $repository */
        $repository = $this->entityManager->getRepository(User::class);

        $resultCode = Result::FAILURE_CREDENTIAL_INVALID;
        $identity = null;
        $resultText = ['Nok'];

        /** @var User $user */
        $user = $repository->findByEmailAndPassword($this->getUsername(), $this->getPassword());

        if ($user) {
            $userData = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'avatar' => $user->getAvatar(),
                'name' => $user->getName(),
                'last_login' => time(),
                'previous_last_login' => $user->getLastLogin()
            ];

            $resultCode = Result::SUCCESS;
            $identity = ['user' => $userData];
            $resultText = ['Ok'];

            (new Container(SessionNamespace::NAME))
                ->getManager()
                ->rememberMe($this->ttl);
        }

        return new Result($resultCode, $identity, $resultText);
    }
}
