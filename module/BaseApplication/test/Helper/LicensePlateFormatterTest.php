<?php

namespace Test\BaseApplication\Helper;

use BaseApplication\Helper\LicensePlateFormatter;
use PHPUnit_Framework_TestCase;

/**
 * Class LicensePlateFormatterTest
 * @package Test\BaseApplication\Helper
 */
class LicensePlateFormatterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function removeMask()
    {
        $licensePlate = 'AAA-0000';
        $licensePlateFormatter = new LicensePlateFormatter();

        $this->assertEquals('AAA0000', $licensePlateFormatter->removeMask($licensePlate));
    }

    /**
     * @test
     */
    public function applyMask()
    {
        $licensePlate1 = 'AAA0000';
        $licensePlate2 = 'abc0000';
        $licensePlateFormatter = new LicensePlateFormatter();

        $this->assertEquals('AAA-0000', $licensePlateFormatter->applyMask($licensePlate1));
        $this->assertEquals('ABC-0000', $licensePlateFormatter->applyMask($licensePlate2));
    }
}
