<?php

namespace BaseApplication\Helper;

/**
 * Class PhoneFormatter
 * @package BaseApplication\Helper
 */
class PhoneFormatter
{
    /**
     * @param $phone
     *
     * @return string
     */
    public function getAreaCode($phone)
    {
        $phone = str_replace(['(', ')', ' ', '-'], '', $phone);

        return substr($phone, 0, 2);
    }

    /**
     * @param $phone
     *
     * @return string
     */
    public function getPhoneWithoutAreaCode($phone)
    {
        $phone = str_replace(['(', ')', ' ', '-'], '', $phone);

        return substr($phone, 2, strlen($phone));
    }
}
