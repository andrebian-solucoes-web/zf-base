<?php

namespace Test\BaseApplication\Assets\Form;

use BaseApplication\Assets\Form\FormNameField;
use PHPUnit\Framework\TestCase;

/**
 * Class FormNameFieldTest
 * @package Test\BaseApplication\Assets\Form
 */
class FormNameFieldTest extends TestCase
{
    /**
     * @test
     */
    public function getInputFilterElement()
    {
        $formSubmit = FormNameField::getNameField();

        $this->assertNotNull($formSubmit);
        $this->assertArrayHasKey('options', $formSubmit);
        $this->assertArrayHasKey('attributes', $formSubmit);
    }
}
