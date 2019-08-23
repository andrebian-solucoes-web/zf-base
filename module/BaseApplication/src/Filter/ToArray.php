<?php

namespace BaseApplication\Filter;

use Zend\Filter\AbstractFilter;
use Zend\Filter\Exception;

/**
 * Class ToArray
 * @package BaseApplication\Filter
 */
class ToArray extends AbstractFilter
{
    /**
     * @var string
     */
    private $delimiter = ' ';

    /**
     * Returns the result of filtering $value
     *
     * @param mixed $value
     * @return mixed
     * @throws Exception\RuntimeException If filtering $value is impossible
     */
    public function filter($value)
    {
        $delimiter = isset($this->options['delimiter']) ?: $this->delimiter;
        $result = [];

        if (strstr($value, $delimiter)) {
            $result = explode($delimiter, $value);
        }

        return $result;
    }

    /**
     * @param $delimiter
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
    }
}
