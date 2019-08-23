<?php declare(strict_types=1);

namespace BaseApplication\Types;

/**
 * Class Cnpj
 * @package BaseApplication\Types
 */
class Cnpj implements Document
{
    /**
     * @var string|int
     */
    private $cnpj;

    /**
     * Cnpj constructor.
     * @param $cnpj
     */
    public function __construct($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    /**
     * @inheritDoc
     */
    public function masked(): string
    {
        $cnpj = $this->unmasked();

        if (strlen($cnpj) !== 14) {
            return '';
        }

        $pattern = "/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/";
        $replacement = "\$1.\$2.\$3/\$4-\$5";

        return (string)preg_replace($pattern, $replacement, $cnpj);
    }

    /**
     * @inheritDoc
     */
    public function unmasked(): string
    {
        return (string)preg_replace("/\D/", '', $this->cnpj);
    }

    public function __toString()
    {
        return (string)$this->masked();
    }
}
