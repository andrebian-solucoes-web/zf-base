<?php

namespace BaseApplication\Entity;

/**
 * Interface ApplicationEntityInterface
 * @package BaseApplication\Entity
 */
interface ApplicationEntityInterface
{

    /**
     * @return string
     */
    public function __toString();

    /**
     * @return array
     */
    public function toArray();
}
