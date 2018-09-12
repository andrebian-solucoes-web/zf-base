<?php
/**
 * Created by PhpStorm.
 * User: andrebian - Andre Cardoso https://github.com/andrebian
 * Date: 07/09/18
 * Time: 11:06
 */

namespace BaseApplication\Filter;

use Zend\Filter\FilterInterface;

/**
 * Class ClearQuotes
 * @package BaseApplication\Filter
 */
class RemoveQuotes implements FilterInterface
{
    /**
     * @inheritdoc
     */
    public function filter($value)
    {
        if (strpos($value, '"') !== false) {
            $value = str_replace('"', '', $value);
        }

        if (strpos($value, '\'') === 0) {
            $value = str_replace('\'', '', $value);
        }

        return $value;
    }
}
