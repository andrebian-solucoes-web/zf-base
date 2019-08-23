<?php declare(strict_types=1);

namespace BaseApplication\Types;

/**
 * Class FloatVal
 * @package BaseApplication\Types
 */
class FloatVal
{
    /**
     * @var float
     */
    private $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function toPercent($asInt = false)
    {
        $percent = number_format((float)$this->value, 2, '.', '');
        if ($asInt) {
            $percent = (int)ceil($percent);
        }
        return  $percent . '%';
    }

    /**
     * @return string
     */
    public function toBRL()
    {
        return 'R$' . number_format((float)$this->value, 2, ',', '.');
    }

    /**
     * @return int
     */
    public function toInt()
    {
        return (int)ceil($this->value);
    }
}
