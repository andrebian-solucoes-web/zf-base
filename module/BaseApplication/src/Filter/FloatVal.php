<?php

namespace BaseApplication\Filter;

use Zend\Filter\AbstractFilter;
use Zend\Filter\Exception;

/**
 * Class FloatVal
 * @package BaseApplication\Filter
 */
class FloatVal extends AbstractFilter
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
        $value = str_replace(['.', ','], ['', '.'], $value);

        return (float)$value;
    }
}
