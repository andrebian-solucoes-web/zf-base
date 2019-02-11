<?php

namespace Test\BaseApplication\View\Helper;

use BaseApplication\View\Helper\ZapLoadingViewHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class ZapLoadingViewHelperTest
 * @package Test\BaseApplication\View\Helper
 */
class ZapLoadingViewHelperTest extends TestCase
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
