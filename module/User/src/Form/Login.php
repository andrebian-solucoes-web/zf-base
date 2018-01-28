<?php

namespace User\Form;

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

        $this->add(array(
            'name' => 'email',
            'options' => array(
                'type' => 'Email',
                'label' => 'Email:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => 'Informe o email',
                'autocomplete' => 'Off'
            )
        ));

        $this->add(array(
            'name' => 'password',
            'options' => array(
                'type' => 'Password',
                'label' => 'Senha:'
            ),
            'attributes' => array(
                'id' => 'password',
                'placeholder' => 'Entre com a senha',
                'class' => 'form-control',
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'options' => [
                'label' => '<i class="entypo-login"></i>Login',
                'label_options' => array(
                    'disable_html_escape' => true,
                ),
            ],
            'attributes' => array(
                'value' => 'Login',
                'class' => 'btn btn-primary btn-block btn-login'
            )
        ));
    }
}
