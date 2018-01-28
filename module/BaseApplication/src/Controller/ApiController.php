<?php

namespace BaseApplication\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

/**
 * Class ApiController
 * @package BaseApplication\Controller
 */
class ApiController extends AbstractRestfulController
{
    /**
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected function getServiceLocator()
    {
        return $this->getEvent()->getApplication()->getServiceManager();
    }

    /**
     * @param $content
     */
    protected function renderJson($content)
    {
        $content = json_encode($content);
        header('Content-Type: application/json');
        print $content;
        exit;
    }

    protected function renderFail()
    {
        print 'fail';
        exit;
    }
}
