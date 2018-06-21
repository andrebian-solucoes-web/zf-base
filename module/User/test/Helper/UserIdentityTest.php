<?php
/**
 * Created by PhpStorm.
 * User: andrebian
 * Date: 20/06/18
 * Time: 23:48
 */

namespace Test\User\Helper;

use PHPUnit\Framework\TestCase;
use User\Helper\UserIdentity;

/**
 * Class UserIdentityTest
 * @package Test\User\Helper
 *
 * @group User
 * @group Helper
 */
class UserIdentityTest extends TestCase
{
    public function testGetIdentityFail()
    {
        $helper = new UserIdentity();

        $result = $helper->getIdentity('Application');

        $this->assertFalse($result);
    }
}
