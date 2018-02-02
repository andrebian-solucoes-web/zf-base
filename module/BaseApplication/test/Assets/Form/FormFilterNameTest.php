<?php

namespace Test\BaseApplication\Assets\Form;

use BaseApplication\Assets\Form\FormFilterName;
use PHPUnit_Framework_TestCase;

/**
 * Class FormFilterNameTest
 * @package Test\BaseApplication\Assets\Form
 */
class FormFilterNameTest extends PHPUnit_Framework_TestCase
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
