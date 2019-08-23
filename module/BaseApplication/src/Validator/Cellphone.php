<?php

namespace BaseApplication\Validator;

use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

/**
 * Class Cellphone
 * @package BaseApplication\Validator
 */
class Cellphone extends AbstractValidator
{
    const INVALID = 'invalid';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID => "Invalid cellphone number",
    ];

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param mixed $value
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value)
    {
        $value = preg_replace("/\D/", '', $value);

        $regexCel = '/[0-9]{2}[6789][0-9]{3,4}[0-9]{4}/'; // Regex para validar somente celular
        if (preg_match($regexCel, $value)) {
            return true;
        }

        $this->error(self::INVALID);

        return false;
    }
}
