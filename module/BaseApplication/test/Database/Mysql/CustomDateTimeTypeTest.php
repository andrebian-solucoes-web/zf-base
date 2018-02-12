<?php

namespace Test\BaseApplication\Database\Mysql;

use BaseApplication\Database\Mysql\CustomDateTimeType;
use DateTime;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit_Framework_TestCase;

/**
 * Class CustomDateTimeTypeTest
 * @package Test\BaseApplication\Database\Mysql
 */
class CustomDateTimeTypeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function convertToPHPValue()
    {
        $platform = new MySqlPlatform();
        $value = date('Y/m/d H:i:s');

        Type::overrideType('datetime', CustomDateTimeType::class);

        $type = Type::getType('datetime');

        $result = $type->convertToPHPValue($value, $platform);

        $this->assertInstanceOf(DateTime::class, $result);
        $this->assertInstanceOf(DateTime::class, $type->convertToPHPValue(new DateTime(), $platform));
        $this->assertNull($type->convertToPHPValue('0000-00-00 00:00:00', $platform));
    }
}
