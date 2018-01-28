<?php

namespace BaseApplication\Helper;

/**
 * Class LicensePlateFormatter
 * @package BaseApplication\Helper
 */
class LicensePlateFormatter
{
    public function removeMask($string)
    {
        return str_replace('-', '', trim($string));
    }

    public function applyMask($string)
    {
        $string = $this->removeMask($string);
        return strtoupper(substr($string, 0, 3) . '-' . substr($string, 3, 4));
    }
}
