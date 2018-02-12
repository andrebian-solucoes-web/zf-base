<?php

namespace Test\BaseApplication\Filter;

use BaseApplication\Filter\FloatVal;
use DateTime;
use PHPUnit_Framework_TestCase;

/**
 * Class FloatValTest
 * @package Test\BaseApplication\Filter
 */
class FloatValTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function filter()
    {
        $filter = new FloatVal();
        $value = '1,99';

        $this->assertEquals(1.99, $filter->filter($value));
    }

    /**
     * @test
     */
    public function filterNotScalar()
    {
        $filter = new FloatVal();
        $value = new DateTime();

        $this->assertInstanceOf(DateTime::class, $filter->filter($value));
    }
}
