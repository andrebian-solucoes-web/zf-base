<?php

namespace User\Form;

use Zend\Form\Element\Email;
use Zend\Form\Element\File;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * Class UserForm
 * @package User\Form
 */
class UserForm extends Form
{
    public function __construct($name = 'user')
    {
        parent::__construct($name);

        $this->setAttribute('role', 'form');

        $filter = new UserFormFilter();
        $this->setInputFilter($filter->getInputFilter());

        $this->add([
            'name' => 'id',
            'type' => Hidden::class
        ]);

        $this->add([
            'name' => 'name',
            'type' => Text::class,
            'options' => [
                'label' => 'Nome Completo *'
            ],
            'attributes' => [
                'class' => 'form-control',
                'id' => 'name',
                'placeholder' => 'Nome Completo',
                'autocomplete' => 'Off'
            ]
        ]);

        $this->add([
            'name' => 'username',
            'type' => Email::class,
            'options' => [
                'label' => 'Email *'
            ],
            'attributes' => [
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => 'email@dominio.com.br',
                'autocomplete' => 'Off'
            ]
        ]);

        $this->add([
            'name' => 'password',
            'type' => Password::class,
            'options' => [
                'label' => 'Senha *'
            ],
            'attributes' => [
                'id' => 'password',
                'placeholder' => 'Informe a senha',
                'class' => 'form-control',
                'autocomplete' => 'off'
            ]
        ]);

        $this->add([
            'name' => 'avatar',
            'type' => File::class,
            'options' => [
                'label' => 'Imagem de perfil'
            ],
            'attributes' => [
                'id' => 'avatar',
                'class' => 'form-control',
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'options' => [
                'label' => 'Save'
            ],
            'attributes' => [
                'value' => 'Save',
                'class' => 'btn btn-primary'
            ]
        ]);
    }
}
