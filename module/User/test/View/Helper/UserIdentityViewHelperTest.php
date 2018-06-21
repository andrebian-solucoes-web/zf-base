<?php
/**
 * Created by PhpStorm.
 * User: andrebian
 * Date: 21/06/18
 * Time: 00:03
 */

namespace View\Helper;

use PHPUnit\Framework\TestCase;
use User\View\Helper\UserIdentityViewHelper;

/**
 * Class UserIdentityViewHelperTest
 * @package View\Helper
 *
 * @group User
 * @group ViewHelper
 */
class UserIdentityViewHelperTest extends TestCase
{
    public function testViewHelper()
    {
        $viewHelper = new UserIdentityViewHelper();

        $this->assertNotNull($viewHelper());
    }
}
