<?php

namespace User\Form;

use Zend\Form\Element\Email;
use Zend\Form\Element\File;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Textarea;
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
            'options' => [
                'type' => Hidden::class
            ]
        ]);

        $this->add([
            'name' => 'name',
            'options' => [
                'type' => Textarea::class,
                'label' => 'Name'
            ],
            'attributes' => [
                'class' => 'form-control',
                'id' => 'name',
                'placeholder' => 'Type your name',
                'autocomplete' => 'Off'
            ]
        ]);

        $this->add([
            'name' => 'username',
            'options' => [
                'type' => Email::class,
                'label' => 'Email'
            ],
            'attributes' => [
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => 'Type your email',
                'autocomplete' => 'Off'
            ]
        ]);

        $this->add([
            'name' => 'password',
            'options' => [
                'type' => Password::class,
                'label' => 'Password'
            ],
            'attributes' => [
                'id' => 'password',
                'placeholder' => 'Type your password',
                'class' => 'form-control',
                'autocomplete' => 'off'
            ]
        ]);

        $this->add([
            'name' => 'avatar',
            'options' => [
                'type' => File::class,
                'label' => 'Avatar'
            ],
            'attributes' => [
                'id' => 'avatar',
                'placeholder' => 'Set your avatar',
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
                'class' => 'btn btn-danger'
            ]
        ]);
    }
}
