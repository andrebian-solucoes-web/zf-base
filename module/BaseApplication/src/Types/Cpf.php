<?php declare(strict_types=1);

namespace BaseApplication\Types;

/**
 * Class Cpf
 * @package BaseApplication\Types
 */
class Cpf implements Document
{
    /**
     * @var string|int
     */
    private $cpf;

    /**
     * Cnpj constructor.
     * @param $cpf
     */
    public function __construct($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @inheritDoc
     */
    public function masked(): string
    {
        $cpf = $this->unmasked();

        if (strlen($cpf) !== 11) {
            return '';
        }

        $pattern = "/(\d{3})(\d{3})(\d{3})(\d{2})/";
        $replacement = "\$1.\$2.\$3-\$4";

        return preg_replace($pattern, $replacement, $cpf);
    }

    /**
     * @inheritDoc
     */
    public function unmasked(): string
    {
        return preg_replace("/\D/", '', $this->cpf);
    }

    public function __toString()
    {
        return (string)$this->masked();
    }
}
