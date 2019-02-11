<?php

namespace Test\BaseApplication\Validator;

use BaseApplication\Validator\NameAndLastName;
use PHPUnit\Framework\TestCase;

/**
 * Class NameAndLastNameTest
 * @package Test\BaseApplication\Validator
 */
class NameAndLastNameTest extends TestCase
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
