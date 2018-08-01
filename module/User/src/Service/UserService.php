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
}
