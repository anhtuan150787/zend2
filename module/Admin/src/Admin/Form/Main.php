<?php
namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element\Captcha;
use Zend\Captcha\Image as CaptchaImage;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\NotEmpty;

class Main extends Form implements InputFilterProviderInterface
{
    protected $inputFilter;
    protected $captcha;

    protected $validateEmpty;

    public function init()
    {
        parent::init();

        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 600
                )
            )
        ));

        $this->getCaptcha();

        $this->getValidateElement();
    }

    public function getInputFilterSpecification() {}

    public function getValidateElement()
    {
        $this->validateEmpty = [
            'name' => 'not_empty',
            'options' => [
                'messages' => [
                    NotEmpty::IS_EMPTY => 'Vui lòng nhập thông tin',
                ]
            ],
            'break_chain_on_failure' => true,
        ];

        return $this;
    }

    public function getCaptcha()
    {
        $configCaptcha = include 'config/captcha.php';
        $this->captcha = new CaptchaImage($configCaptcha);

        return $this;
    }
}