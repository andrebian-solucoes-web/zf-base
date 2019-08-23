<?php

namespace User\Controller\Admin;

use BaseApplication\Controller\CrudController;
use Doctrine\ORM\EntityManager;
use User\Assets\SessionNamespace;
use User\Entity\User;
use User\Form\UserForm;
use User\Helper\UserIdentity;
use User\Service\UserService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\View\Model\ViewModel;

/**
 * Class UserController
 * @package User\Controller\Admin
 */
class UserController extends CrudController
{
    public function __construct()
    {
        $this->service = UserService::class;
        $this->form = UserForm::class;
        $this->repository = User::class;
        $this->redirectTo = 'admin-user';
        $this->redirectMethod = 'toRoute';
    }

    /**
     * @inheritdoc
     */
    public function onDispatch(MvcEvent $e)
    {
        $this->layout('layout/admin');
        $this->layout()->setVariable('menuItem', 'user');
        return parent::onDispatch($e);
    }

    public function addAction()
    {
        $this->form = new UserForm();
        $this->form->getInputFilter()->get('password')->setRequired(true);

        return parent::addAction();
    }

    public function editAction()
    {
        $this->form = new UserForm();
        $this->form->get('password')->setLabel('Senha');

        return parent::editAction();
    }


    /**
     * @return \Zend\Http\Response|ViewModel
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function profileAction()
    {
        $form = new UserForm();

        $entityManager = $this->getServiceManager()
            ->get(EntityManager::class);
        $userIdentity = new UserIdentity();
        $loggedUser = $userIdentity->getIdentity(SessionNamespace::NAME);

        /** @var User $user */
        $user = $entityManager->find(User::class, $loggedUser['id']);
        $userData = $user->toArray();
        unset($userData['password']);

        $form->setData($userData);

        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost()
                ->toArray();

            $form->setData($data);
            if (! $form->isValid()) {
                $errorMessages = $form->getMessages();
                return new ViewModel([
                    'form' => $form,
                    'errorMessages' => $errorMessages,
                    'user' => $user
                ]);
            }

            $flashNamespace = FlashMessenger::NAMESPACE_ERROR;
            $flashMessage = 'Profile not edited';

            /** @var UserService $service */
            $service = $this->getServiceManager()
                ->get(UserService::class);
            $data = $this->parseAvatar(
                $user,
                $form->getData()
            );

            if ($service->save($data)) {
                $flashNamespace = FlashMessenger::NAMESPACE_SUCCESS;
                $flashMessage = 'Profile edited';
            }

            $this->flashMessenger()
                ->setNamespace($flashNamespace)
                ->addMessage($flashMessage);

            return $this->redirect()
                ->toRoute('admin-user', ['action' => 'profile']);
        }

        return new ViewModel([
            'form' => $form,
            'user' => $user
        ]);
    }

    /**
     * @param User $user
     * @param array $data
     * @return array
     */
    private function parseAvatar(User $user, array $data)
    {
        $files = $this->getRequest()
            ->getFiles()
            ->toArray();
        if (isset($files['avatar'])
            && $files['avatar']['error'] === 0) {
            /** @var UserService $service */
            $service = $this->getServiceManager()
                ->get(UserService::class);
            $data['avatar'] = $service->uploadAvatar($files['avatar'], $data['id']);

            $this->updateAvatarSession($user, $data['avatar']);
        }

        return $data;
    }

    /**
     * @param User $user
     * @param $avatar
     */
    private function updateAvatarSession(User $user, $avatar)
    {
        $userData = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'avatar' => $avatar,
            'name' => $user->getName(),
            'last_login' => time(),
            'previous_last_login' => $user->getLastLogin()
        ];

        $sessionStorage = new SessionStorage(SessionNamespace::NAME);
        $sessionStorage->clear();
        $sessionStorage->write($userData);
    }
}
