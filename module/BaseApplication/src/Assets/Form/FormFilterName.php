<?php

namespace BaseApplication\Assets\Form;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Validator\StringLength;

/**
 * Class FormFilterName
 * @package BaseApplication\Assets\Form
 */
class FormFilterName
{
    public static function getInputFilterElement()
    {
        return [
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 255,
                    ],
                ],
            ],
        ];
    }
}
