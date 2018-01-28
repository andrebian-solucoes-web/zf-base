<?php

namespace BaseApplication\Database\Mysql;

use DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;

/**
 * Class CustomDateTimeType
 * @package BaseApplication\Database\Mysql
 */
class CustomDateTimeType extends DateTimeType
{
    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return bool|DateTime|false|mixed|null
     * @throws \Doctrine\DBAL\Types\ConversionException
     *
     * Using: put the following sample of code in config/autoload/doctrine_orm.[global,local].php
     *
     * 'doctrine' => [
     *      ...
     *      'dbal' => [
     *          'types' => [
     *              'datetime' => \Application\Database\Mysql\CustomDateTimeType::class
     *          ]
     *      ]
     * ]
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof DateTime) {
            return $value;
        }

        if ('0000-00-00 00:00:00' === $value) {
            return null;
        }

        return parent::convertToPHPValue($value, $platform);
    }
}
