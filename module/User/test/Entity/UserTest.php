<?php

namespace Tests\Unit\User\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use User\Entity\PasswordRecoveryToken;
use User\Entity\Role;
use User\Entity\User;

/**
 * Class UserTest
 * @package Tests\Unit\User\Entity
 *
 * @group User
 * @group Entity
 */
class UserTest extends TestCase
{
    /**
     * @test
     */
    public function checkGettersAndSetters()
    {
        $entity = new User();

        $passwordRecoveries = new ArrayCollection();
        $passwordRecoveries->add(new PasswordRecoveryToken());

        $entity->setName('1');
        $entity->setPassword('11231321');
        $entity->setLastLogin(new DateTime());
        $entity->setAvatar('12345.jpg');
        $entity->setUsername('1');
        $entity->setId('1');
        $entity->setCreated(new DateTime());
        $entity->setModified(new DateTime());
        $entity->setActive('1');
        $entity->setRole(new Role());
        $entity->setPasswordRecoveries($passwordRecoveries);

        $this->assertNotNull($entity->getName());
        $this->assertNotNull($entity->getPassword());
        $this->assertNotNull($entity->getLastLogin());
        $this->assertNotNull($entity->getAvatar());
        $this->assertNotNull($entity->getUsername());
        $this->assertNotNull($entity->getId());
        $this->assertNotNull($entity->getCreated());
        $this->assertNotNull($entity->getModified());
        $this->assertNotNull($entity->isActive());
        $this->assertNotNull(sprintf($entity));
        $this->assertNotNull($entity->getPasswordRecoveries());
        $this->assertNotNull($entity->getRole());
    }
}
