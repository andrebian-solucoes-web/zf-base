<?php

namespace BaseApplication\Validator;

use Zend\Validator\AbstractValidator;

/**
 * Class InRange
 * @package BaseApplication\Validator
 */
class InRange extends AbstractValidator
{
    const INVALID = 'invalid';
    const NOT_IN_RANGE = 'notInRange';

    /**
     * @var string|array
     */
    private $range;

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID => "Please provide a valid value",
        self::NOT_IN_RANGE => "The value provided is not in range"
    ];

    public function __construct($options = null)
    {
        parent::__construct($options);

        if (isset($options['range'])) {
            $range = $options['range'];
            if (! is_array($range)) {
                $range = explode(',', $range);
            }

            $this->range = $range;
        }
    }


    /**
     * @inheritdoc
     */
    public function isValid($value)
    {
        $valid = false;

        $value = mb_strtolower($value);

        if (in_array($value, $this->range)) {
            return true;
        }

        return $valid;
    }
}
