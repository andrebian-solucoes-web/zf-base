<?php

namespace BaseApplication\Controller;

/**
 * Trait ServiceManagerTrait
 * @package BaseApplication\Controller
 */
trait ServiceManagerTrait
{
    /**
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected function getServiceManager()
    {
        return $this->getEvent()->getApplication()->getServiceManager();
    }
}
