<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Admin\Form\SelfForm;
use Admin\Model\UserTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Version\Version;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function selfAction()
    {
        if ($this->getRequest()->isPost()) {
            $form = new SelfForm();
            $form->loadInputFilter();
            $form->setData($_POST);
            if ($form->isValid()) {
                $data     = $form->getData();
                $identity = $this->identity();
                if ($data['password']) {
                    $identity->setPassword($data['password']);
                }
                $identity->setRealName($data['real_name']);
                $identity->setEmail($data['email']);

                $userTable = new UserTable();
                $userTable->save($identity);
                return new JsonModel(array('code' => 1));
            } else {
                return new JsonModel(array(
                    'code'   => 0,
                    'errors' => $form->getInputFilter()->getMessages()
                ));
            }
        }

        (new ViewModel());

        return array();
    }
}
