<?php

namespace BaseApplication;

use BaseApplication\Mail\Mail;
use BaseApplication\View\Helper\AuthUserViewHelper;
use BaseApplication\View\Helper\BrazilianStateHelperComboViewHelper;
use BaseApplication\View\Helper\FormatDateViewHelper;
use BaseApplication\View\Helper\IsDevModeViewHelper;
use BaseApplication\View\Helper\JsonDecodeViewHelper;
use BaseApplication\View\Helper\Slugify;
use Exception;
use User\Assets\SessionNamespace;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class Module
 * @package BaseApplication
 */
class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Mail::class => function (ServiceManager $serviceManager) {
                    $emailConfig = $serviceManager->get('config')['mail'];
                    $transport = $serviceManager->get('SendGridTransport');

                    try {
                        $renderer = $serviceManager->get('ViewRenderer');
                    } catch (Exception $e) {
                        $renderer = new PhpRenderer();
                    }

                    return new Mail($transport, $emailConfig, $renderer, 'contact');
                }
            ]
        ];
    }

    public function getViewHelperConfig()
    {
        return [
            'invokables' => [
                'zapLoading' => View\Helper\ZapLoading::class,
                'isDevMode' => IsDevModeViewHelper::class,
                'jsonDecode' => JsonDecodeViewHelper::class,
                'formatDate' => FormatDateViewHelper::class,
                'slugify' => Slugify::class,
                'brazilianStateCombo' => BrazilianStateHelperComboViewHelper::class,
                'user' => AuthUserViewHelper::class,
                'authUser' => AuthUserViewHelper::class,
            ]
        ];
    }

    /**
     * @param ModuleManager $moduleManager
     */
    public function init(ModuleManager $moduleManager)
    {
        // Uncomment this if you need that all actions for this module were authenticated
//        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
//        $sharedEvents->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, function (MvcEvent $event) {
//
//            $auth = new AuthenticationService();
//            $auth->setStorage(new Session(SessionNamespace::NAME));
//
//            /** @var AbstractActionController $controller */
//            $controller = $event->getTarget();
//
//            if (!$auth->hasIdentity()) {
//                return $controller->redirect()->toRoute('login');
//            }
//
//        }, 100);
    }
}
