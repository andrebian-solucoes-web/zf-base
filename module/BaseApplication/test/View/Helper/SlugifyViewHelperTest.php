<?php

namespace Test\BaseApplication\View\Helper;

use BaseApplication\View\Helper\SlugifyViewHelper;
use PHPUnit_Framework_TestCase;

/**
 * Class SlugifyViewHelperTest
 * @package Test\BaseApplication\View\Helper
 */
class SlugifyViewHelperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function invoke()
    {
        $slugify = new SlugifyViewHelper();

        $this->assertEquals('a-simple-string', $slugify('A simple String'));
        $this->assertEquals('com-acentuacao-removida', $slugify('Com acentuação removida'));
    }
}
