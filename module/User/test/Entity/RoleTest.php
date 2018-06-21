<?php
/**
 * Created by PhpStorm.
 * User: andrebian
 * Date: 20/06/18
 * Time: 22:12
 */

namespace Test\User\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use User\Entity\Role;
use User\Entity\User;

/**
 * Class RoleTest
 * @package Test\User\Entity
 *
 * @group User
 * @group Entity
 */
class RoleTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $users = new ArrayCollection();
        $users->add(new User());

        $data = [
            'name' => 'Admin',
            'users' => $users
        ];

        $role = new Role($data);

        $this->assertNotNull($role->getName());
        $this->assertNotNull($role->getUsers());
        $this->assertEquals('Admin', sprintf($role));
    }
}
