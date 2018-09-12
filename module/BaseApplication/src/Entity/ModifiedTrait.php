<?php
/**
 * Created by PhpStorm.
 * User: andrebian - Andre Cardoso https://github.com/andrebian
 * Date: 28/08/18
 * Time: 14:32
 */

namespace BaseApplication\Entity;

use DateTime;

/**
 * Trait ModifiedTrait
 * @package BaseApplication\Entity
 */
trait ModifiedTrait
{
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    protected $modified;

    /**
     * @return DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param DateTime|null $modified
     * @return $this
     */
    public function setModified(?DateTime $modified)
    {
        $this->modified = $modified;
        return $this;
    }
}
