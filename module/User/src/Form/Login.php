<?php

namespace User\Form;

use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Form;

/**
 * Class Login
 * @package User\Form
 */
class Login extends Form
{
    public function __construct($name = 'login')
    {
        parent::__construct($name);

        $this->setAttribute('role', 'form');
        $this->setAttribute('id', 'form_login');

        $filter = new LoginFormFilter();
        $this->setInputFilter($filter->getInputFilter());

        $this->add([
            'name' => 'email',
            'options' => [
                'type' => Email::class,
                'label' => 'Email:'
            ],
            'attributes' => [
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => 'Informe o email',
                'autocomplete' => 'Off'
            ]
        ]);

        $this->add([
            'name' => 'password',
            'options' => [
                'type' => Password::class,
                'label' => 'Senha:'
            ],
            'attributes' => [
                'id' => 'password',
                'placeholder' => 'Entre com a senha',
                'class' => 'form-control',
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'options' => [
                'label' => '<i class="entypo-login"></i>Login',
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            'attributes' => [
                'value' => 'Login',
                'class' => 'btn btn-primary btn-block btn-login'
            ]
        ]);
    }
}
