<?php

namespace BaseApplication\Controller;

use BaseApplication\Repository\AbstractApplicationRepository;
use BaseApplication\Service\ServiceInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Exception;
use Zend\Form\Form;
use Zend\Http\Request;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

/**
 * Class CrudController
 * @package BaseApplication\Controller
 */
abstract class CrudController extends BaseController
{
    /**
     * @var ServiceInterface
     */
    protected $service;

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var AbstractApplicationRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $redirectMethod = 'toUrl';

    /**
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * @var array
     */
    protected $orderBy = [];

    /**
     * @var array
     */
    protected $criteria = ['active' => true];

    /**
     * Override if you need for a specific case
     *
     * @return ViewModel
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function addAction()
    {
        $errorMessages = [];
        /** @var Request $request */
        $request = $this->getRequest();

        if (! is_object($this->form)) {
            /** @var Form $form */
            $form = new $this->form();
        } else {
            $form = $this->form;
        }

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();

            if (method_exists($this, 'bindPreFormData')) {
                $data = $this->bindPreFormData($data);
            }

            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                if (method_exists($this, 'bindDataToService')) {
                    $data = $this->bindDataToService($data);
                }

                /** @var ServiceInterface $service */
                $service = $this->getServiceManager()->get($this->service);

                if ($service->save($data)) {
                    $this->flashMessenger()->setNamespace('success')
                        ->addMessage('Register added');

                    return $this->redirect()->{$this->redirectMethod}($this->redirectTo);
                }
            } else {
                $errorMessages = $form->getMessages();
            }
        }

        return new ViewModel([
            'form' => $form,
            'errorMessages' => $errorMessages
        ]);
    }

    /**
     * Override if you need for a specific case
     *
     * @return ViewModel
     * @throws Exception
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function editAction()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getServiceManager()->get(EntityManager::class);
        $errorMessages = [];
        /** @var Request $request */
        $request = $this->getRequest();

        $form = $this->form;
        if (! is_object($form)) {
            /** @var Form $form */
            $form = new $this->form('edit', true);
        }

        $id = (int)$this->params()->fromRoute('id', 0);
        if ($id === 0) {
            throw new Exception('Invalid Register');
        }

        $data = $entityManager->find($this->repository, $id);

        $formData = $data->toArray();
        $formData['active'] = 1;

        if (! $data->isActive()) {
            $formData['active'] = 0;
        }

        if (method_exists($this, 'bindDataToForm')) {
            $formData = $this->bindDataToForm($formData);
        }

        $form->setData($formData);

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            if (! isset($data['id']) || empty($data['id'])) {
                $data['id'] = $id;
            }

            if (method_exists($this, 'bindPreFormData')) {
                $data = $this->bindPreFormData($data);
            }

            $form->setData($data);

            if ($form->isValid()) {
                /** @var ServiceInterface $service */
                $service = $this->getServiceManager()->get($this->service);

                $data = $form->getData();
                if (method_exists($this, 'bindDataToService')) {
                    $data = $this->bindDataToService($data);
                }

                if ($service->save($data)) {
                    $this->flashMessenger()->setNamespace('success')
                        ->addMessage('Register edited');

                    return $this->redirect()->{$this->redirectMethod}($this->redirectTo);
                }
            } else {
                $errorMessages = $form->getMessages();
            }
        }

        return new ViewModel([
            'form' => $form,
            'errorMessages' => $errorMessages,
            'data' => $data
        ]);
    }

    /**
     * Override if you need for a specific case
     *
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function deleteAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        if ($request->isPost() || $request->isDelete()) {
            $id = (int)$this->params()->fromRoute('id', 0);
            /** @var ServiceInterface $service */
            $service = $this->getServiceManager()->get($this->service);

            if ($service->delete($id)) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('Register deleted');
            }
        }

        return $this->redirect()->{$this->redirectMethod}($this->redirectTo);
    }

    /**
     * Override if you need for a specific case
     *
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function inactivateAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        if ($request->isPost() || $request->isDelete()) {
            $id = (int)$this->params()->fromRoute('id', 0);
            /** @var ServiceInterface $service */
            $service = $this->getServiceManager()->get($this->service);

            if ($service->inactivate($id)) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('Register inactivated');
            }
        }

        return $this->redirect()->{$this->redirectMethod}($this->redirectTo);
    }

    /**
     * Override if you need for a specific case
     *
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function activateAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        if ($request->isPost() || $request->isDelete()) {
            $id = (int)$this->params()->fromRoute('id', 0);
            /** @var ServiceInterface $service */
            $service = $this->getServiceManager()->get($this->service);

            if ($service->activate($id)) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('Register activated');
            }
        }

        return $this->redirect()->{$this->redirectMethod}($this->redirectTo);
    }

    /**
     * Override if you need for a specific case
     *
     * @return ViewModel
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function viewAction()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getServiceManager()->get(EntityManager::class);
        $id = (int)$this->params()->fromRoute('id', 0);
        $data = $entityManager->find($this->repository, $id);

        return new ViewModel([
            'data' => $data
        ]);
    }

    /**
     * Override if you need for a specific case
     *
     * @param bool $active
     * @return ViewModel
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function indexAction($active = true)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getServiceManager()->get(EntityManager::class);
        $this->criteria['active'] = $active;

        $query = $entityManager->getRepository($this->repository)->findBy($this->criteria, $this->orderBy);

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
        $paginator->setDefaultItemCountPerPage(30);
        $paginator->setView();

        return new ViewModel([
            'collection' => $paginator
        ]);
    }

    /**
     * Override if you need for a specific case
     *
     * @return ViewModel
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function showInactiveAction()
    {
        return $this->indexAction(false);
    }
}
