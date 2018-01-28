<?php

namespace User\Entity;

use BaseApplication\Entity\AbstractApplicationEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Role
 * @package User\Entity
 *
 * @ORM\Table(name="user_roles")
 * @ORM\Entity
 */
class Role extends AbstractApplicationEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="User\Entity\User", mappedBy="role")
     */
    private $users;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Role
     */
    public function setName(string $name): Role
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param Collection $users
     * @return Role
     */
    public function setUsers(Collection $users): Role
    {
        $this->users = $users;
        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function __construct(array $data = [])
    {
        $this->users = new ArrayCollection();
        parent::__construct($data);
    }
}
