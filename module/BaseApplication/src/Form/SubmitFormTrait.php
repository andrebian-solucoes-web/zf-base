<?php

namespace BaseApplication\Form;

use RuntimeException;
use Zend\Form\Form;

/**
 * Trait SubmitFormTrait
 * @package BaseApplication\Form
 */
trait SubmitFormTrait
{
    /**
     * @return $this
     */
    public function submit()
    {
        if (! $this instanceof Form) {
            throw new RuntimeException('Trait only useful with forms');
        }

        return $this;
    }

    /**
     * @param $value
     */
    public function setValue($value)
    {
        if (! $this instanceof Form) {
            throw new RuntimeException('Trait only useful with forms');
        }

        $attributes = $this->get('submit')->getAttributes();
        $attributes['value'] = $value;
        $this->get('submit')->setAttributes($attributes);
    }
}
