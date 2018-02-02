<?php

namespace Test\BaseApplication\Assets\Form;

use BaseApplication\Assets\Form\FormSaveButton;
use PHPUnit_Framework_TestCase;

/**
 * Class FormSaveButtonTest
 * @package Test\BaseApplication\Assets\Form
 */
class FormSaveButtonTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getInputFilterElement()
    {
        $filterElement = FormSaveButton::getSaveButton();

        $this->assertNotNull($filterElement);
        $this->assertArrayHasKey('options', $filterElement);
        $this->assertArrayHasKey('attributes', $filterElement);
    }
}
