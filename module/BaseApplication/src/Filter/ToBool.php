<?php

namespace BaseApplication\Filter;

use Zend\Filter\AbstractFilter;
use Zend\Filter\Exception;

/**
 * Class ToBool
 * @package BaseApplication\Filter
 */
class ToBool extends AbstractFilter
{
    /**
     * Returns the result of filtering $value
     *
     * @param mixed $value
     * @return mixed
     * @throws Exception\RuntimeException If filtering $value is impossible
     */
    public function filter($value)
    {
        return (bool)$value;
    }
}
