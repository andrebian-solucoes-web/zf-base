<?php

namespace Tests\Unit\User\Entity;

use DateTime;
use PHPUnit_Framework_TestCase;
use User\Entity\User;

/**
 * Class UserTest
 * @package Tests\Unit\User\Entity
 *
 * @group Unit
 * @group Entity
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function checkGettersAndSetters()
    {
        $entity = new User();

        $entity->setName('1');
        $entity->setPassword('11231321');
        $entity->setLastLogin(new DateTime());
        $entity->setAvatar('1');
        $entity->setUsername('1');
        $entity->setId('1');
        $entity->setCreated(new DateTime());
        $entity->setModified(new DateTime());
        $entity->setActive('1');

        $this->assertNotNull($entity->getName());
        $this->assertNotNull($entity->getPassword());
        $this->assertNotNull($entity->getLastLogin());
        $this->assertNotNull($entity->getAvatar());
        $this->assertNotNull($entity->getUsername());
        $this->assertNotNull($entity->getId());
        $this->assertNotNull($entity->getCreated());
        $this->assertNotNull($entity->getModified());
        $this->assertNotNull($entity->isActive());
    }
}
