<?php

namespace User\Service;

use BaseApplication\Service\BaseService;
use DateTime;
use User\Entity\User;

/**
 * Class UserService
 * @package User\Service
 */
class UserService extends BaseService
{
    public function save(array $data, $isTest = false)
    {
        if ($this->isEmailInUse($data)) {
            $this->errors = ['username' => ['E-mail já cadastrado']];
            return false;
        }

        return parent::save($data, $isTest);
    }

    /**
     * @param $userId
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function updateLastLogin($userId)
    {
        /** @var User $user */
        $user = $this->entityManager->find(User::class, $userId);
        $user->setLastLogin(new DateTime());
        $this->entityManager->flush();

        return true;
    }

    public function uploadAvatar($avatar, $id)
    {
        return $this->uploadFile($avatar, 'avatar/' . $id);
    }

    /**
     * @param $file
     * @param $pathName
     * @return string
     */
    private function uploadFile($file, $pathName)
    {
        $path = __DIR__ . '/../../../../public/files/' . $pathName;
        if (! is_dir($path)) {
            mkdir($path, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $path . '/' . $file['name'])) {
            return $file['name'];
        }

        return '';
    }

    /**
     * @param array $data
     * @return bool
     */
    private function isEmailInUse(array $data)
    {
        $email = $data['username'];

        $exists = $this->entityManager->getRepository(User::class)
            ->findOneBy(['username' => $email]);

        if ($exists && isset($data['id']) && $data['id'] != $exists->getId()) {
            return true;
        }

        return false;
    }
}
