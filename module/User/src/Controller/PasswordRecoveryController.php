<?php

namespace User\Controller;

use BaseApplication\Controller\BaseController;
use DateTime;
use Doctrine\ORM\EntityManager;
use User\Entity\PasswordRecoveryToken;
use User\Service\PasswordRecoveryService;
use Zend\Http\Request;
use Zend\View\Model\ViewModel;

/**
 * Class PasswordRecoveryController
 * @package User\Controller
 */
class PasswordRecoveryController extends BaseController
{
    /**
     * @return \Zend\Http\Response|ViewModel
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function indexAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            /** @var PasswordRecoveryService $passwordRecoveryService */
            $passwordRecoveryService = $this->getServiceManager()->get(PasswordRecoveryService::class);
            if ($passwordRecoveryService->startRecoverPassword($request->getPost('email'))) {
                $this->flashMessenger()->setNamespace('success')->addMessage('E-mail para a recuperação de senha enviado. Siga as instruções do mesmo.');

                return $this->redirect()->toRoute('login');
            }

            $this->flashMessenger()->setNamespace('error')->addMessage('O e-mail informado não está cadastrado em nossa base de dados.');

            return $this->redirect()->toRoute('login');
        }

        return new ViewModel();
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function recoverPasswordAction()
    {
        $email = $this->params()->fromQuery('email');
        $token = $this->params()->fromQuery('token');

        $entityManager = $this->getServiceManager()->get(EntityManager::class);
        /** @var PasswordRecoveryToken $passwordRecoveryToken */
        if (!$passwordRecoveryToken = $entityManager->getRepository(PasswordRecoveryToken::class)->findOneBy([
            'active' => true,
            'token' => $token
        ])) {
            $this->flashMessenger()->setNamespace('error')->addMessage('Token inválido.');

            return $this->redirect()->toRoute('password-recovery-error');
        }

        if ($passwordRecoveryToken->getUser()->getUsername() != $email) {
            $this->flashMessenger()->setNamespace('error')->addMessage('E-mail inválido.');

            return $this->redirect()->toRoute('password-recovery-error');
        }

        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            if ($data['password'] !== $data['password-confirmation']) {
                $this->flashMessenger()->setNamespace('error')->addMessage('As senhas não coincidem.');

                return $this->redirect()->toUrl('/recovery-password-action?email=' . $email . '&token=' . $token);
            }

            $user = $passwordRecoveryToken->getUser();
            $user->setPassword($data['password'])->setModified(new DateTime());
            $passwordRecoveryToken->setActive(false)->setModified(new DateTime());

            $entityManager->persist($user);
            $entityManager->flush();

            $this->flashMessenger()->setNamespace('success')->addMessage('Senha alterada.');

            return $this->redirect()->toRoute('login');
        }

        return new ViewModel();
    }

    public function errorAction()
    {
        return new ViewModel();
    }
}
