<?php

namespace BaseApplication\Filter;

use DateTime;
use Zend\Filter\AbstractFilter;
use Zend\Filter\Exception;

/**
 * Class DateTimeFilter
 * @package BaseApplication\Filter
 */
class DateTimeFilter extends AbstractFilter
{
    /**
     * Returns the result of filtering $value
     *
     * @param  mixed $value
     * @throws Exception\RuntimeException If filtering $value is impossible
     * @return mixed
     */
    public function filter($value)
    {
        if (!is_scalar($value)) {
            return $value;
        }
        $value = (string)$value;
        $value = str_replace('/', '-', $value);

        return new DateTime($value);
    }
}
