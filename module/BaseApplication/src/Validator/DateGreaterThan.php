<?php

namespace BaseApplication\Validator;

use ArrayAccess;
use BaseApplication\Filter\ToDateTime;
use Traversable;
use Zend\Stdlib\ArrayUtils;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

/**
 * Class DateGreaterThan
 * @package BaseApplication\Validator
 */
class DateGreaterThan extends AbstractValidator
{
    /**
     * Error codes
     * @const string
     */
    const SMALLER = 'smaller';
    const MISSING_TOKEN = 'missingToken';
    const NOT_COMPARABLE = 'notComparable';

    /**
     * Error messages
     * @var array
     */
    protected $messageTemplates = [
        self::SMALLER => "The final date is smaller than start date",
        self::MISSING_TOKEN => 'No token was provided to match against',
        self::NOT_COMPARABLE => 'The given token is not a valid date string'
    ];

    /**
     * @var array
     */
    protected $messageVariables = [
        'token' => 'tokenString'
    ];

    /**
     * Original token against which to validate
     * @var string
     */
    protected $tokenString;
    protected $token;
    protected $strict = true;
    protected $literal = false;

    /**
     * Sets validator options
     *
     * @param  mixed $token
     */
    public function __construct($token = null)
    {
        if ($token instanceof Traversable) {
            $token = ArrayUtils::iteratorToArray($token);
        }

        if (is_array($token) && array_key_exists('token', $token)) {
            if (array_key_exists('strict', $token)) {
                $this->setStrict($token['strict']);
            }

            if (array_key_exists('literal', $token)) {
                $this->setLiteral($token['literal']);
            }

            $this->setToken($token['token']);
        } elseif (null !== $token) {
            $this->setToken($token);
        }

        parent::__construct(is_array($token) ? $token : null);
    }

    public function isValid($value, $context = null)
    {
        $this->setValue($value);
        $token = $this->getToken();

        if (! $this->getLiteral() && $context !== null) {
            if (! is_array($context) && ! ($context instanceof ArrayAccess)) {
                throw new Exception\InvalidArgumentException(sprintf(
                    'Context passed to %s must be array, ArrayObject or null; received "%s"',
                    __METHOD__,
                    is_object($context) ? get_class($context) : gettype($context)
                ));
            }

            if (is_array($token)) {
                while (is_array($token)) {
                    $key = key($token);
                    if (! isset($context[$key])) {
                        break;
                    }
                    $context = $context[$key];
                    $token = $token[$key];
                }
            }

            // if $token is an array it means the above loop didn't went all the way down to the leaf,
            // so the $token structure doesn't match the $context structure
            if (is_array($token) || ! isset($context[$token])) {
                $token = $this->getToken();
            } else {
                $token = $context[$token];
            }
        }

        try {
            $filter = new ToDateTime();
            $token = $filter->filter($token);
        } catch (\Exception $exception) {
            $this->error(self::NOT_COMPARABLE);
            return false;
        }

        if ($token === null) {
            $this->error(self::MISSING_TOKEN);
            return false;
        }

        $strict = $this->getStrict();
        if (($strict && ($value > $token)) || (! $strict && ($value > $token))) {
            return true;
        }

        $this->error(self::SMALLER);
        return false;
    }

    /**
     * Retrieve token
     *
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set token against which to compare
     *
     * @param $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->tokenString = (is_array($token) ? var_export($token, true) : (string)$token);
        $this->token = $token;
        return $this;
    }

    /**
     * Returns the literal parameter
     *
     * @return bool
     */
    public function getLiteral()
    {
        return $this->literal;
    }

    /**
     * Sets the literal parameter
     *
     * @param  bool $literal
     * @return $this
     */
    public function setLiteral($literal)
    {
        $this->literal = (bool)$literal;
        return $this;
    }

    /**
     * Returns the strict parameter
     *
     * @return bool
     */
    public function getStrict()
    {
        return $this->strict;
    }

    /**
     * Sets the strict parameter
     *
     * @param  bool $strict
     * @return $this
     */
    public function setStrict($strict)
    {
        $this->strict = (bool)$strict;
        return $this;
    }
}
