<?php

namespace BaseApplication\Controller;

use RuntimeException;
use Zend\Uri\Http;

/**
 * Trait RefererTrait
 * @package BaseApplication\Helper
 */
trait RefererTrait
{
    /**
     * @return string
     */
    public function getReferer()
    {
        if (! $this->getRequest()) {
            throw new RuntimeException('This trait is only useful in a controller');
        }

        /** @var Http $baseReferer */
        $baseReferer = $this->getRequest()->getHeader('referer')->uri();
        $referer = $baseReferer->getScheme() . '://' . $baseReferer->getHost();
        if ($baseReferer->getPort() != 80) {
            $referer .= ':' . $baseReferer->getPort();
        }

        if ($baseReferer->getPath() != '') {
            $referer .= $baseReferer->getPath();
        }

        if ($baseReferer->getQuery() != '') {
            $referer .= '?' . $baseReferer->getQuery();
        }

        return $referer;
    }
}
