<?php

namespace BaseApplication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package BaseApplication
 */
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
