<?php

namespace BaseApplication\Service;

use BaseApplication\Entity\AbstractApplicationEntity;
use BaseApplication\Entity\ApplicationEntityInterface;
use DateTime;
use Doctrine\ORM\EntityManager;
use Exception;
use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\ServiceManager;

/**
 * Class BaseService
 * @package BaseApplication\Service
 */
abstract class BaseService implements ServiceInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var ApplicationEntityInterface
     */
    protected $entity;

    public function __construct(ServiceManager $serviceManager)
    {
        $this->entityManager = $serviceManager->get(EntityManager::class);
        $this->serviceManager = $serviceManager;
    }

    /**
     * @param $id
     * @return bool|mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($id)
    {
        $entity = $this->entityManager->getReference($this->entity, (int)$id);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @param $id
     * @return bool|mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws Exception
     */
    public function inactivate($id)
    {
        return $this->changeStatus($id, false);
    }

    /**
     * @param $id
     * @return bool|mixed
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws Exception
     */
    public function activate($id)
    {
        return $this->changeStatus($id, true);
    }

    /**
     * @param $id
     * @param $active
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    protected function changeStatus($id, $active)
    {
        /** @var AbstractApplicationEntity $entity */
        $entity = $this->entityManager->find($this->getEntityName(), (int)$id);
        $entity->setActive($active)->setModified(new DateTime());

        $this->entityManager->flush();

        return true;
    }

    /**
     * @param array $data
     * @param bool $isTest
     * @return mixed|null|object
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function save(array $data, $isTest = false)
    {
        $entityName = $this->getEntityName($isTest);

        if (! isset($data['id']) || empty($data['id'])) {
            $entity = new $entityName($data);
            $this->entityManager->persist($entity);
        } else {
            $entity = $this->entityManager->find($entityName, (int)$data['id']);
            unset($data['id']);
            (new ClassMethods(false))->hydrate($data, $entity);
            $entity->setModified(new DateTime());
        }

        $this->entityManager->flush();

        return $entity;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array|string
     */
    private function getEntityName($isTest = false)
    {
        $entityName = get_called_class();
        $entityName = explode('\\', $entityName);
        $treatedEntityName = $entityName[0] . '\\Entity\\' . str_replace('Service', '', end($entityName));

        if ($isTest) {
            $lastPiece = end($entityName);
            unset($entityName[(count($entityName)) - 1]);

            $treatedEntityName = implode('\\', $entityName);
            $treatedEntityName .= '\\' . str_replace('Service', 'Entity', $lastPiece);
        }

        return $treatedEntityName;
    }
}
