<?php
/**
 * Created by PhpStorm.
 * User: andrebian
 * Date: 14/06/18
 * Time: 23:59
 */

namespace User\Controller;

use BaseApplication\Controller\CrudController;
use User\Entity\User;
use User\Service\UserService;

class AdminUserController extends CrudController
{
    public function __construct()
    {
        $this->service = UserService::class;
        $this->form = 'UserForm';
        $this->repository = User::class;
    }
}
