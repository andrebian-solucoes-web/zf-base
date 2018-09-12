<?php
/**
 * Created by PhpStorm.
 * User: andrebian - Andre Cardoso https://github.com/andrebian
 * Date: 07/09/18
 * Time: 11:06
 */

namespace BaseApplication\Filter;

use Zend\Filter\FilterInterface;

class CPFMaskFilter implements FilterInterface
{
    /**
     * @inheritdoc
     */
    public function filter($value)
    {
        $value = preg_replace("/\D/", '', $value);
        // Validando se o CPF possui a quantidade certa de caracteres
        if (strlen($value) !== 11) {
            return '';
        }

        // Definindo padrões
        $pattern = "/(\d{3})(\d{3})(\d{3})(\d{2})/";
        $replacement = "\$1.\$2.\$3-\$4";

        // aplicando a máscara
        return preg_replace($pattern, $replacement, $value);
    }
}
