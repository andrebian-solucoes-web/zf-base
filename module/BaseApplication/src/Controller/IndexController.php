<?php

namespace BaseApplication\Controller;
use User\Entity\User;
use User\Form\Login;
use User\Service\UserService;

/**
 * Class IndexController
 * @package BaseApplication
 */
class IndexController extends CrudController implements
    BindPreFormDataInterface, BindDataToFormInterface, BindDataToServiceInterface
{
    public function __construct()
    {
        $this->service = UserService::class;
        $this->repository = User::class;
        $this->form = Login::class;
    }

    /**
     * Intercept data before instantiate form. Eg: on post receive.
     *
     * @param array $data
     * @return mixed
     */
    public function bindPreFormData(array $data)
    {
        return $data;
    }

    /**
     * Prepares data before set it into $form->setData();
     *
     * Here you can extract an entity as itself to an integer value before render form in view, for example.
     * This method is commonly used in edit actions.
     *
     * @param array $data
     * @return mixed
     */
    public function bindDataToForm(array $data)
    {
        return $data;
    }

    /**
     * Prepares data before call $service->save();
     *
     * Here you can fetch the entities references and many others possibilities.
     *
     * @param array $data
     * @return mixed
     */
    public function bindDataToService(array $data)
    {
        return $data;
    }
}
