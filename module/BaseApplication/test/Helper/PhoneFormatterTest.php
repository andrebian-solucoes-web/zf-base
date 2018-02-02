<?php

namespace Test\BaseApplication\Helper;

use BaseApplication\Helper\PhoneFormatter;
use PHPUnit_Framework_TestCase;

/**
 * Class PhoneFormatterTest
 * @package Test\BaseApplication\Helper
 */
class PhoneFormatterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getAreaCode()
    {
        $phone = '(41) 5555-5555';
        $phoneFormatter = new PhoneFormatter();

        $this->assertEquals('41', $phoneFormatter->getAreaCode($phone));
    }

    /**
     * @test
     */
    public function getPhoneWithoutAreaCode()
    {
        $phone = '(41) 5555-6666';
        $phoneFormatter = new PhoneFormatter();

        $this->assertEquals('55556666', $phoneFormatter->getPhoneWithoutAreaCode($phone));
    }
}
