<?php

namespace BaseApplication\View\Helper;

use Slug\Slugifier;
use Zend\View\Helper\AbstractHelper;

/**
 * Class Slugify
 * @package BaseApplication\View\Helper
 */
class Slugify extends AbstractHelper
{
    public function __invoke($string)
    {
        $slugifier = new Slugifier();
        $slugifier->setTransliterate(true);
        $slugifier->setDelimiter('-');

        return $slugifier->slugify($string);
    }
}
