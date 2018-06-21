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
use User\Entity\PasswordRecoveryToken;
use User\Entity\Role;
use User\Entity\User;

/**
 * Class PasswordRecoveryTokenTest
 * @package Test\User\Entity
 *
 * @group User
 * @group Entity
 */
class PasswordRecoveryTokenTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $data = [
            'token' => md5('test'),
            'user' => new User()
        ];

        $entity = new PasswordRecoveryToken($data);

        $this->assertNotNull($entity->getToken());
        $this->assertNotNull($entity->getUser());
        $this->assertEquals(md5('test'), sprintf($entity));
    }
}
