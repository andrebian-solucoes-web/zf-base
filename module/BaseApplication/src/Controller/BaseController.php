<?php

namespace BaseApplication\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class BaseController
 * @package BaseApplication\Controller
 * @codeCoverageIgnore
 */
abstract class BaseController extends AbstractActionController
{
    /**
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected function getServiceManager()
    {
        return $this->getEvent()->getApplication()->getServiceManager();
    }
}
