<?php
/**
 * Created by PhpStorm.
 * User: andrebian
 * Date: 14/06/18
 * Time: 23:59
 */

namespace User\Controller;

use BaseApplication\Controller\CrudController;
use Doctrine\ORM\EntityManager;
use User\Assets\SessionNamespace;
use User\Entity\User;
use User\Form\UserForm;
use User\Helper\UserIdentity;
use User\Service\UserService;
use Zend\Http\Request;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\View\Model\ViewModel;

class AdminUserController extends CrudController
{
    public function __construct()
    {
        $this->service = UserService::class;
        $this->form = UserForm::class;
        $this->repository = User::class;
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

        $entityManager = $this->getServiceManager()->get(EntityManager::class);
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
            $data = $request->getPost()->toArray();

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
            $service = $this->getServiceManager()->get(UserService::class);
            $data = $this->parseAvatar($user, $form->getData());

            if ($service->save($data)) {
                $flashNamespace = FlashMessenger::NAMESPACE_SUCCESS;
                $flashMessage = 'Profile edited';
            }

            $this->flashMessenger()->setNamespace($flashNamespace)->addMessage($flashMessage);

            return $this->redirect()->toRoute('admin-user', ['action' => 'profile']);
        }

        return new ViewModel([
            'form' => $form,
            'user' => $user
        ]);
    }

    private function parseAvatar(User $user, array $data)
    {
        $files = $this->getRequest()->getFiles()->toArray();
        if (isset($files['avatar'])
          && $files['avatar']['error'] === 0) {
            /** @var UserService $service */
            $service = $this->getServiceManager()->get(UserService::class);
            $data['avatar'] = $service->uploadAvatar($files['avatar'], $data['id']);

            $this->updateAvatarSession($user, $data['avatar']);
        }

        return $data;
    }

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
