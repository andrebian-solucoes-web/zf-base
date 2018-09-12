<?php
/**
 * Created by PhpStorm.
 * User: andrebian
 * Date: 29/06/18
 * Time: 22:41
 */

namespace BaseApplication\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class ProductionEnvViewHelper
 * @package BaseApplication\View\Helper
 */
class ProductionEnvViewHelper extends AbstractHelper
{
    public function __invoke()
    {
        if ('cli-server' == php_sapi_name()) {
            return false;
        }

        if (
        (isset($_SERVER['SERVER_ADDR'])
            && strpos($_SERVER['SERVER_ADDR'], 'homologacao') !== false)
        || (isset($_SERVER['HTTP_HOST'])
            && strpos($_SERVER['HTTP_HOST'], 'homologacao') !== false)) {
            return false;
        }

        return true;
    }
}
