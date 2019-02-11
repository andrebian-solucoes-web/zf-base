<?php

namespace BaseApplication\Validator;

use Zend\Validator\AbstractValidator;

/**
 * Class NameAndLastName
 * @package BaseApplication\Validator
 */
class NameAndLastName extends AbstractValidator
{
    const INVALID = 'nameAndLastNameInvalid';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID => "Please provide your name and last name",
    ];


    /**
     * @inheritdoc
     */
    public function isValid($value)
    {
        $words = explode(' ', $value);
        $valid = count($words) > 1;

        if (! $valid) {
            $this->abstractOptions['messages'][self::INVALID] = $this->messageTemplates[self::INVALID];
        }

        return $valid;
    }
}
