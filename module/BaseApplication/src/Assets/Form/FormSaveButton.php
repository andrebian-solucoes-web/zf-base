<?php

namespace BaseApplication\Assets\Form;

use Zend\Form\Element\Submit;

/**
 * Class FormSaveButton
 * @package BaseApplication\Assets\Form
 */
class FormSaveButton
{
    public static function getSaveButton()
    {
        return [
            'name' => 'submit',
            'type' => Submit::class,
            'options' => [
                'label_options' => [
                    'disable_html_escape' => true,
                ],
                'label' => '&nbsp;'
            ],
            'attributes' => [
                'value' => 'Save',
                'class' => 'btn btn-primary btn-block'
            ]

        ];
    }
}
