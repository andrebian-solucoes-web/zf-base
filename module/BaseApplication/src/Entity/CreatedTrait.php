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
 * Trait CreatedTrait
 * @package BaseApplication\Entity
 */
trait CreatedTrait
{
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    protected $created;

    /**
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     * @return $this
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
        return $this;
    }
}
