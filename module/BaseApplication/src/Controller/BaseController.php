<?php

namespace BaseApplication\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class BaseController
 * @package BaseApplication\Controller
 */
abstract class BaseController extends AbstractActionController
{
    /**
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected function getServiceLocator()
    {
        return $this->getEvent()->getApplication()->getServiceManager();
    }
}
