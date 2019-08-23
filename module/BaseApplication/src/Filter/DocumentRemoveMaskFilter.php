<?php

namespace BaseApplication\Filter;

use Zend\Filter\AbstractFilter;

/**
 * Class DocumentRemoveMaskFilter
 * @package BaseApplication\Filter
 */
class DocumentRemoveMaskFilter extends AbstractFilter
{
    /**
     * @param mixed $value
     * @return mixed|string
     */
    public function filter($value)
    {
        return (string)preg_replace("/\D/", '', $value);
    }
}
