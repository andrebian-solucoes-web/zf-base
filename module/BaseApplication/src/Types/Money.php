<?php declare(strict_types=1);

namespace BaseApplication\Types;

/**
 * Class Money
 * @package BaseApplication\Types
 */
class Money
{
    /**
     * @var int
     */
    private $value;

    /**
     * Money constructor.
     * @param $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function toBRL()
    {
        $value = ($this->value / 100);

        return 'R$' . number_format($value, 2, ',', '.');
    }

    /**
     * @return float
     */
    public function toFloat()
    {
        $this->value = $this->value / 100;

        return (float)number_format($this->value, 2, '.', '');
    }

    /**
     * @return int
     */
    public function toCents()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }
}
