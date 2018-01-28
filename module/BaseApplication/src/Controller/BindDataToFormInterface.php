<?php

namespace BaseApplication\Controller;

/**
 * Interface BindDataToFormInterface
 * @package BaseApplication\Controller
 */
interface BindDataToFormInterface
{
    /**
     * Prepares data before set it into $form->setData();
     *
     * Here you can extract an entity as itself to an integer value before render form in view, for example.
     * This method is commonly used in edit actions.
     *
     * @param array $data
     * @return mixed
     */
    public function bindDataToForm(array $data);
}
