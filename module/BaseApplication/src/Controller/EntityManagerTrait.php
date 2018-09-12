<?php

namespace BaseApplication\Controller;

use Doctrine\ORM\EntityManager;

/**
 * Trait EntityManagerTrait
 * @package BaseApplication\Controller
 */
trait EntityManagerTrait
{
    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getEvent()
            ->getApplication()
            ->getServiceManager()
            ->get(EntityManager::class);
    }
}
