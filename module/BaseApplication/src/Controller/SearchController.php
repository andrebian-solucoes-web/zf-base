<?php

namespace BaseApplication\Controller;

use BaseApplication\Repository\ApplicationRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Exception;
use Zend\View\Model\ViewModel;

/**
 * Class SearchController
 * @package BaseApplication\Controller
 */
class SearchController extends BaseController
{
    /**
     * @return ViewModel
     * @throws Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function indexAction()
    {
        $data = $this->params()->fromQuery();
        $repositoryClassName = '\\' . $data['repository'];

        if (!class_exists($repositoryClassName)) {
            throw new Exception('Invalid parameters');
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->getServiceManager()->get(EntityManager::class);
        /** @var ApplicationRepositoryInterface $repository */
        $repository = $entityManager->getRepository($repositoryClassName);
        $data = $repository->search($data);

        return new ViewModel([
            'result' => $data,
            'queryString' => http_build_query($this->params()->fromQuery())
        ]);
    }
}
