<?php
/**
 * Created by PhpStorm.
 * User: andrebian
 * Date: 20/06/18
 * Time: 22:28
 */

namespace Test\User\Form;

use PHPUnit\Framework\TestCase;
use User\Form\Login;
use Zend\Form\Form;

/**
 * Class LoginTest
 * @package Test\User\Form
 *
 * @group User
 * @group Form
 */
class LoginTest extends TestCase
{
    protected $class;
    protected $form;

    protected function setUp()
    {
        $this->class = Login::class;
        $this->form = new $this->class();

        parent::setUp();
    }

    public function getData()
    {
        return array(
            'email' => 'test@test.com',
            'password' => 'test-123',
        );
    }

    public function formFields()
    {
        return [
            ['email'],
            ['password'],
            ['submit'],
        ];
    }

    public function getFormAttributes()
    {
        $dataProviderTest = $this->formFields();
        $definedAttributes = array();
        foreach ($dataProviderTest as $item) {
            $definedAttributes[] = $item[0];
        }

        return $definedAttributes;
    }

    /**
     * @test
     */
    public function classIsASubClassOfZendForm()
    {
        $class = class_parents($this->form);
        $formExtendsOf = current($class);
        $this->assertEquals(Form::class, $formExtendsOf);
    }


    /**
     * @test
     * @dataProvider formFields()
     */
    public function checkFormFields($fieldName)
    {
        $this->assertTrue($this->form->has($fieldName), 'Field "' . $fieldName . '" not found.');
    }


    /**
     * @test
     *
     * Test if the attributes are in the form and config in tests
     */
    public function isAttributsMirrored()
    {
        $definedAttributes = $this->getFormAttributes();
        $attributesFormClass = $this->form->getElements();
        $attributesForm = array();
        foreach ($attributesFormClass as $key => $value) {
            $attributesForm[] = $key;
            $messageAssert = 'Attribute "' . $key . '" not found in class test. Value - ' . $value->getName();
            $this->assertContains($key, $definedAttributes, $messageAssert);
        }

        $this->assertTrue(($definedAttributes === $attributesForm), 'Attributes not equals.');
    }

    /**
     * @test
     */
    public function completeDataAreValid()
    {
        $this->form->setData($this->getData());
        $this->assertTrue($this->form->isValid());
    }
}
