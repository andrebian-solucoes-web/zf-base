<?php

namespace Test\BaseApplication\View\Helper;

use BaseApplication\View\Helper\JsonDecodeViewHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class JsonDecodeViewHelperTest
 * @package Test\BaseApplication\View\Helper
 */
class JsonDecodeViewHelperTest extends TestCase
{
    /**
     * @test
     */
    public function invoke()
    {
        $jsonDecodeViewHelper = new JsonDecodeViewHelper();

        $jsonContent = '{"test": true, "pass": "ok"}';

        $this->assertInternalType('object', $jsonDecodeViewHelper($jsonContent));
        $this->assertInternalType('array', $jsonDecodeViewHelper($jsonContent, true));
    }
}
