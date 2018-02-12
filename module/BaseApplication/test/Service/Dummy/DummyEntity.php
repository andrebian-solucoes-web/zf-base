<?php

namespace Test\BaseApplication\Service\Dummy;

use BaseApplication\Entity\AbstractApplicationEntity;

/**
 * Class DummyEntity
 * @package Test\BaseApplication\Service\Dummy
 */
class DummyEntity extends AbstractApplicationEntity
{
    /**
     * @return string
     */
    public function __toString()
    {
        return '';
    }
}
