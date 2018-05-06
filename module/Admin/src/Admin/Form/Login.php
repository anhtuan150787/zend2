<?php
namespace Admin\Form;

use Zend\Form\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Login extends Main
{
    public function init($name = null)
    {
        parent::init();

        $this->add(array(
            'name' => 'account_username',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Tài khoản',
                'class' => 'form-control',
                'required' => 'required',
            ],
        ));

        $this->add(array(
            'name' => 'account_password',
            'type' => 'Password',
            'attributes' => [
                'placeholder' => 'Mật khẩu',
                'class' => 'form-control',
                'required' => 'required',
            ],
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'Captcha',
            'options' => [
                'captcha' => $this->captcha,
            ],
            'attributes' => [
                'placeholder' => 'Mã xác thực',
                'class' => 'form-control captcha-input',
                'required' => 'required',
            ],
        ));

        $this->add(array(
            'name' => 'account_submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Đăng nhập',
                'id' => 'submitbutton',
                'class' => 'btn btn-default submit',
            ),
        ));
    }

    public function getInputFilterSpecification()
    {
        parent::getInputFilterSpecification();

        $inputFilter = [
            'account_username' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StringTrim'],
                    ['name' => 'StripTags']
                ],
                'validators' => [$this->validateEmpty]
            ],
            'account_password' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StringTrim'],
                    ['name' => 'StripTags']
                ],
                'validators' => [$this->validateEmpty]
            ],
        ];

        return $inputFilter;
    }


}