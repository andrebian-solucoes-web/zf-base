<?php

namespace BaseApplication\Assets\Form;

use Zend\Form\Element\Text;

/**
 * Class FormNameField
 * @package BaseApplication\Assets\Form
 */
class FormNameField
{
    public static function getNameField()
    {
        return [
            'name' => 'name',
            'type' => Text::class,
            'options' => [
                'label' => 'Name'
            ],
            'attributes' => [
                'class' => 'form-control',
                'id' => 'name',
                'placeholder' => 'Name',
                'autocomplete' => 'Off'
            ]
        ];
    }
}
