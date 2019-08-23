<?php

namespace BaseApplication\Form;

use RuntimeException;
use Zend\Form\Form;

/**
 * Trait SetClassesFormTrait
 * @package BaseApplication\Form
 */
trait SetClassesFormTrait
{
    /**
     * @param array $input
     */
    public function setClasses(array $input)
    {
        if (! $this instanceof Form) {
            throw new RuntimeException('Trait only useful with forms');
        }

        foreach ($input as $field => $class) {
            $currentAttributes = $this->get($field)->getAttributes();
            $currentAttributes['class'] = $class;
            $this->get($field)->setAttributes($currentAttributes);
        }
    }
}
