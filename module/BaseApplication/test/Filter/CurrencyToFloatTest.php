<?php

namespace Test\BaseApplication\Filter;

use BaseApplication\Filter\CurrencyToFloat;
use DateTime;
use PHPUnit_Framework_TestCase;

/**
 * Class CurrencyToFloatTest
 * @package Test\BaseApplication\Filter
 */
class CurrencyToFloatTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function filter()
    {
        $filter = new CurrencyToFloat();
        $value = 'R$ 1,99';

        $this->assertEquals(1.99, $filter->filter($value));
    }

    /**
     * @test
     */
    public function filterNotScalar()
    {
        $filter = new CurrencyToFloat();
        $value = new DateTime();

        $this->assertInstanceOf(DateTime::class, $filter->filter($value));
    }
}
