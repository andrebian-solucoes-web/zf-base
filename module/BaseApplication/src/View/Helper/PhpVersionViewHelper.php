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
 * Class PhpVersionViewHelper
 * @package BaseApplication\View\Helper
 */
class PhpVersionViewHelper extends AbstractHelper
{
    public function __invoke()
    {
        return phpversion();
    }
}
