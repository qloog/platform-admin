<?php
/**
 * platform-admin SelfForm.php
 * @DateTime 13-4-26 下午2:59
 */

namespace Admin\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Validator\Callback;

/**
 * Class SelfForm
 * @package Admin\Form
 * @author Moln Xie
 * @version $Id: SelfForm.php 885 2013-05-22 03:08:41Z maomao $
 */
class SelfForm extends Form
{
    public function loadInputFilter()
    {
        $inputFilter = new InputFilter();
        $factory     = new InputFactory();

        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'       => 'password',
                    'required'   => false,
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'min' => 6,
                                'max' => 16
                            ),
                        ),
                    ),
                )
            )
        );

        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'       => 'confirm_password',
                    'required'   => false,
                    'validators' => array(
                        array(
                            'name'    => 'Callback',
                            'options' => array(
                                'callback' => function ($value, $row) {
                                    return $row['password'] == $value;
                                }
                            ),
                            'messages' => array(
                                Callback::INVALID_VALUE => '两次输入的密码不一致'
                            ),
                        ),
                    ),
                )
            )
        );

        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'real_name',
                    'required' => true,
                )
            )
        );
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name'     => 'email',
                    'required' => true,
                    'validators' => array(
                        array('name' => 'EmailAddress'),
                    ),
                )
            )
        );
        $this->setInputFilter($inputFilter);
    }
}