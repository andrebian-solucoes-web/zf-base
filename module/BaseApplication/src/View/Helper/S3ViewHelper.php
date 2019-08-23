<?php

namespace BaseApplication\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class S3ViewHelper
 * @package BaseApplication\View\Helper
 */
class S3ViewHelper extends AbstractHelper
{
    public function __invoke()
    {
        $globalConfig = require __DIR__ . '/../../../../../config/autoload/global.php';
        $baseUrl = $globalConfig['base_url'];

        $localConfig = __DIR__ . '/../../../../../config/autoload/local.php';
        if (is_file($localConfig)) {
            $localConfig = require $localConfig;
            $baseUrl = $localConfig['base_url'];
        }

        return $baseUrl . '/files';
    }
}
