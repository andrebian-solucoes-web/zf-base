<?php

namespace Test\BaseApplication\Helper;

use BaseApplication\Helper\PriceFormatter;
use PHPUnit_Framework_TestCase;

/**
 * Class PriceFormatterTest
 * @package Test\BaseApplication\Helper
 */
class PriceFormatterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function applyMask()
    {
        $price = 1.99;
        $price2 = 'R$ 1,99';
        $priceFormatter = new PriceFormatter();

        $this->assertEquals('R$ 1,99', $priceFormatter->applyMask($price, false));
        $this->assertEquals('R$ 1,99', $priceFormatter->applyMask($price2));
    }

    /**
     * @test
     */
    public function removeMask()
    {
        $price = 'R$ 1,99';
        $priceFormatter = new PriceFormatter();

        $this->assertEquals('1.99', $priceFormatter->removeMask($price));
    }

    /**
     * @test
     */
    public function toFloat()
    {
        $price = 'R$ 1,99';
        $priceFormatter = new PriceFormatter();

        $this->assertEquals(1.99, $priceFormatter->toFloat($price));
    }
}
