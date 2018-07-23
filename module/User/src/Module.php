<?php

namespace User;

use Doctrine\ORM\EntityManager;
use User\Assets\SessionNamespace;
use User\Auth\Adapter;
use User\Service\PasswordRecoveryService;
use User\Service\UserService;
use User\View\Helper\UserIdentityViewHelper;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;

/**
 * Class Module
 * @package User
 * @codeCoverageIgnore
 */
class Module implements DependencyIndicatorInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Adapter::class => function (ServiceManager $serviceManager) {
                    $entityManager = $serviceManager->get(EntityManager::class);

                    return new Adapter($entityManager);
                },
                UserService::class => function (ServiceManager $serviceManager) {
                    return new UserService($serviceManager);
                },
                PasswordRecoveryService::class => function (ServiceManager $serviceManager) {
                    return new PasswordRecoveryService($serviceManager);
                }
            ],
        ];
    }

    public function getViewHelperConfig()
    {
        return [
            'invokables' => [
                'userIdentity' => UserIdentityViewHelper::class,
                'user' => UserIdentityViewHelper::class,
                'authUser' => UserIdentityViewHelper::class,
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

            $whitelist = [
                'login',
                'password-recovery',
                'recovery-password-action',
                'password-recovery-error',
                'admin-login',
                'admin-password-recovery',
                'admin-recovery-password-action',
                'admin-password-recovery-error'
            ];

            $redirect = 'login';
            if (strpos($matchedRoute, 'admin-') !== false) {
                $redirect = 'admin-login';
            }

            if (! $auth->hasIdentity() && ! in_array($matchedRoute, $whitelist)) {
                return $controller->redirect()->toRoute($redirect);
            }

        }, 100);
    }

    /**
     * Expected to return an array of modules on which the current one depends on
     *
     * @return array
     */
    public function getModuleDependencies()
    {
        return [
            'BaseApplication'
        ];
    }
}
