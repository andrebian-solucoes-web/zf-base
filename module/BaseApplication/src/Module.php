<?php

namespace BaseApplication;

use BaseApplication\Mail\Mail;
use BaseApplication\View\Helper\BrazilianStateHelperComboViewHelper;
use BaseApplication\View\Helper\JsonDecodeViewHelper;
use BaseApplication\View\Helper\SlugifyViewHelper;
use BaseApplication\View\Helper\ZapLoadingViewHelper;
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
 * @codeCoverageIgnore
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
                'zapLoading' => ZapLoadingViewHelper::class,
                'jsonDecode' => JsonDecodeViewHelper::class,
                'slugify' => SlugifyViewHelper::class,
                'brazilianStateCombo' => BrazilianStateHelperComboViewHelper::class
            ]
        ];
    }

    /**
     * @param ModuleManager $moduleManager
     */
    public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, function (MvcEvent $event) {

            $auth = new AuthenticationService();
            $auth->setStorage(new Session(SessionNamespace::NAME));

            /** @var AbstractActionController $controller */
            $controller = $event->getTarget();
            $matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();

            $redirect = 'login';
            if (strpos($matchedRoute, 'admin') !== false) {
                $redirect = 'admin-login';
            }

            if (!$auth->hasIdentity() && $matchedRoute == 'admin') {
                return $controller->redirect()->toRoute($redirect);
            }

        }, 100);
    }
}
