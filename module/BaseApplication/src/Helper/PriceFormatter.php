<?php

namespace BaseApplication\Helper;

/**
 * Class PriceFormatter
 * @package BaseApplication\Helper
 */
class PriceFormatter
{
    /**
     * @param $price
     * @param bool $fromFormInput
     * @return string
     */
    public function applyMask($price, $fromFormInput = true)
    {
        if ($fromFormInput) {
            $price = str_replace(['R$ ', '.', ','], ['', '', '.'], $price);
        }
        return 'R$ ' . number_format($price, 2, ',', '.');
    }

    /**
     * @param $price
     * @return mixed
     */
    public function removeMask($price)
    {
        return str_replace(['R$ ', '.', ','], ['', '', '.'], $price);
    }

    /**
     * @param $price
     * @return mixed
     */
    public function toFloat($price)
    {
        return (float)$this->removeMask($price);
    }
}
