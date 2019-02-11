<?php
/**
 * Created by PhpStorm.
 * User: andrebian - Andre Cardoso https://github.com/andrebian
 * Date: 28/08/18
 * Time: 14:34
 */

namespace BaseApplication\Entity;

/**
 * Trait IdTrait
 * @package BaseApplication\Entity
 */
trait IdTrait
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var int
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return IdTrait
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}
