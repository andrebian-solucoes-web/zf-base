<?php

namespace Test\BaseApplication\Filter;

use BaseApplication\Filter\DateTimeFilter;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class DateTimeFilterTest
 * @package Test\BaseApplication\Filter
 */
class DateTimeFilterTest extends TestCase
{
    /**
     * @test
     */
    public function filter()
    {
        $filter = new DateTimeFilter();
        $value = date('d/m/Y');

        $this->assertInstanceOf(DateTime::class, $filter->filter($value));
    }

    /**
     * @test
     */
    public function filterNotScalar()
    {
        $filter = new DateTimeFilter();
        $value = new ArrayCollection();

        $this->assertInstanceOf(ArrayCollection::class, $filter->filter($value));
    }
}
