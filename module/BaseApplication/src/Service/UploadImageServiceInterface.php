<?php

namespace BaseApplication\Service;

use BaseApplication\Entity\ApplicationEntityInterface;

/**
 * Interface UploadImageServiceInterface
 * @package BaseApplication\Service
 */
interface UploadImageServiceInterface
{
    /**
     * @param ApplicationEntityInterface $entity
     * @param array $image
     * @return mixed|null|string
     */
    public function uploadImage(ApplicationEntityInterface $entity, array $image);
}
