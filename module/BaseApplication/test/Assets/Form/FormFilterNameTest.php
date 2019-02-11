<?php

namespace Test\BaseApplication\Assets\Form;

use BaseApplication\Assets\Form\FormFilterName;
use PHPUnit\Framework\TestCase;

/**
 * Class FormFilterNameTest
 * @package Test\BaseApplication\Assets\Form
 */
class FormFilterNameTest extends TestCase
{
    /**
     * @test
     */
    public function getInputFilterElement()
    {
        $filterElement = FormFilterName::getInputFilterElement();

        $this->assertNotNull($filterElement);
        $this->assertArrayHasKey('filters', $filterElement);
        $this->assertArrayHasKey('validators', $filterElement);
    }
}
