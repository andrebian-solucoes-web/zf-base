<?php
/**
 * Created by PhpStorm.
 * User: andrebian - Andre Cardoso https://github.com/andrebian
 * Date: 28/08/18
 * Time: 15:02
 */

namespace BaseApplication\Entity;

use Zend\Hydrator\ClassMethods;

/**
 * Trait ToArrayTrait
 * @package BaseApplication\Entity
 */
trait ToArrayTrait
{
    /**
     * @return array
     */
    public function toArray()
    {
        $hydrator = new ClassMethods(false);
        return $hydrator->extract($this);
    }
}
