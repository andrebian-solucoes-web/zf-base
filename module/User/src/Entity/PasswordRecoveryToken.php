<?php

namespace User\Entity;

use BaseApplication\Entity\AbstractApplicationEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PasswordRecoveryToken
 * @package User\Entity
 *
 * @ORM\Table(name="user_password_recoveries")
 * @ORM\Entity
 */
class PasswordRecoveryToken extends AbstractApplicationEntity
{
    /**
     * @var string
     * @ORM\Column(name="token", type="string", length=255, nullable=false)
     */
    private $token;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User\Entity\User", inversedBy="passwordRecoveries")
     */
    private $user;

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->token;
    }
}
