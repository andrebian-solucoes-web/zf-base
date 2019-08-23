<?php declare(strict_types=1);

namespace User\Entity;

use BaseApplication\Entity\AbstractApplicationEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user_users")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="User\Repository\UserRepository")
 */
class User extends AbstractApplicationEntity
{
    const PROFILE = 'admin';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=60, nullable=false)
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(name="avatar", type="text", nullable=true)
     */
    private $avatar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="User\Entity\PasswordRecoveryToken", mappedBy="user")
     */
    private $passwordRecoveries;

    /**
     * @var Role
     * @ORM\ManyToOne(targetEntity="User\Entity\Role", inversedBy="users")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private $role;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $pushToken;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        if (strlen($password) >= 6) {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        }

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     *
     * @return $this
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }


    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     *
     * @return $this
     */
    public function setAvatar($avatar)
    {
        if (strlen($avatar) > 5) {
            $this->avatar = $avatar;
        }

        return $this;
    }

    public function __toString()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPasswordRecoveries()
    {
        return $this->passwordRecoveries;
    }

    /**
     * @param ArrayCollection $passwordRecoveries
     * @return $this
     */
    public function setPasswordRecoveries(ArrayCollection $passwordRecoveries)
    {
        $this->passwordRecoveries = $passwordRecoveries;

        return $this;
    }

    /**
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param Role $role
     * @return User
     */
    public function setRole(Role $role): User
    {
        $this->role = $role;
        return $this;
    }

    public function __construct(array $data = [])
    {
        $this->passwordRecoveries = new ArrayCollection();
        parent::__construct($data);
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getProfile(): string
    {
        return 'admin';
    }

    /**
     * @param string|null $pushToken
     * @return $this
     */
    public function setPushToken(?string $pushToken)
    {
        $this->pushToken = $pushToken;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPushToken(): ?string
    {
        return $this->pushToken;
    }
}
