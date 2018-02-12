<?php

namespace Test\BaseApplication\Validator;

use BaseApplication\Validator\NameAndLastName;
use PHPUnit_Framework_TestCase;

/**
 * Class NameAndLastNameTest
 * @package Test\BaseApplication\Validator
 */
class NameAndLastNameTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function isValid()
    {
        $validator = new NameAndLastName();
        $name = 'Andre';
        $nameAndLastName = 'Andre Cardoso';

        $this->assertFalse($validator->isValid($name));
        $this->assertTrue($validator->isValid($nameAndLastName));
    }
}
