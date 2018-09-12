<?php
/**
 * Created by PhpStorm.
 * User: andrebian - Andre Cardoso https://github.com/andrebian
 * Date: 28/08/18
 * Time: 14:27
 */

namespace BaseApplication\Entity;

/**
 * Trait ActiveTrait
 * @package BaseApplication\Entity
 */
trait ActiveTrait
{
    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=false, options={"default" = true})
     */
    protected $active = true;

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return ActiveTrait
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }
}
