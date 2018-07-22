<?php

namespace User\Controller;

use BaseApplication\Controller\BaseController;
use User\Assets\SessionNamespace;
use User\Auth\Adapter;
use User\Form\Login;
use User\Service\UserService;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Http\Request;
use Zend\View\Model\ViewModel;

/**
 * Class AdminAuthController
 * @package User\Controller
 */
class AdminAuthController extends BaseController
{
    /**
     * @return \Zend\Http\Response|ViewModel
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function indexAction()
    {
        $form = new Login();
        /** @var Request $request */
        $request = $this->getRequest();
        $errorMessages = [];

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setData($data);

            if ($form->isValid()) {
                $auth = new AuthenticationService();
                $sessionStorage = new SessionStorage(SessionNamespace::NAME);
                $auth->setStorage($sessionStorage);

                /** @var Adapter $authAdapter */
                $authAdapter = $this->getServiceManager()->get(Adapter::class);
                $authAdapter->setUsername($data['email'])->setPassword($data['password']);

                $result = $auth->authenticate($authAdapter);
                if ($result->isValid()) {
                    $authUser = $auth->getIdentity()['user'];
                    $sessionStorage->write($authUser);
                    /** @var UserService $userService */
                    $userService = $this->getServiceManager()->get(UserService::class);
                    $userService->updateLastLogin((int)$authUser['id']);

                    return $this->redirect()->toRoute('admin');
                } else {
                    unset($data['password']);
                    $errorMessages = 'E-mail e/ou senha inválidos';
                }
            } else {
                $errorMessages = $form->getMessages();
            }
        }

        return new ViewModel([
            'loginForm' => $form,
            'errorMessages' => $errorMessages
        ]);
    }

    public function logoutAction()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new SessionStorage(SessionNamespace::NAME));
        $auth->clearIdentity();

        return $this->redirect()->toRoute('admin-login');
    }
}
