<?php

namespace Test\BaseApplication\View\Helper;

use BaseApplication\View\Helper\ZapLoadingViewHelper;
use PHPUnit_Framework_TestCase;

/**
 * Class ZapLoadingViewHelperTest
 * @package Test\BaseApplication\View\Helper
 */
class ZapLoadingViewHelperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function invoke()
    {
        $zapLoading = new ZapLoadingViewHelper();

        $this->assertContains('<svg', $zapLoading());
    }
}
