<?php

namespace Test\BaseApplication\Assets\Form;

use BaseApplication\Assets\Form\FormSaveButton;
use PHPUnit\Framework\TestCase;

/**
 * Class FormSaveButtonTest
 * @package Test\BaseApplication\Assets\Form
 */
class FormSaveButtonTest extends TestCase
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
