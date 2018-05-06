<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Admin\Form\Login;
use Zend\Authentication\Adapter\DbTable;
use Zend\Authentication\Storage\Session;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{
    public function onDispatch(MvcEvent $e)
    {
        $this->layout('layout/login');

        return parent::onDispatch($e);
    }

    public function indexAction()
    {
        $authService = new AuthenticationService();
        if ($authService->hasIdentity()) {
            $this->redirect()->toRoute('admin');
        }

        $view = new ViewModel();
        $form = new Login('login');
        $form->init();

        $request = $this->getRequest();

        if ($request->isPost()) {

            $dataPost = $request->getPost();
            $form->setData($dataPost);

            if ($form->isValid()) {

                $encrypt = $this->getServiceLocator()->get('Encrypt');
                $accountModel = $this->getServiceLocator()->get('Model')->getModel('Application\Model\Account');
                $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');

                $username = $dataPost['account_username'];
                $password = $dataPost['account_password'];

                $userInfo = $accountModel->fetchRow(['WHERE' => 'account_username = "' . $username . '" AND account_status = 1']);

                $salt = $userInfo['account_password_salt'];
                $authAdapter = new DbTable($dbAdapter);
                $authAdapter->setTableName('account')->setIdentityColumn('account_username')->setCredentialColumn('account_password');
                $authAdapter->setIdentity($username)->setCredential($encrypt->HashPass($password, $salt));

                $result = $authAdapter->authenticate();
                $isValid = $result->isValid();

                if ($isValid) {

                    $storage = new Session();
                    $storage->write($authAdapter->getResultRowObject([
                        'account_id',
                        'account_email',
                        'account_name',
                        'account_picture',
                        'group_account_id',
                        'account_username',
                    ]));
                    $authService->setStorage($storage)->setAdapter($authAdapter);

                    $this->redirect()->toRoute('admin/default', ['controller' => 'index', 'action' => 'index']);

                }
                $msgError = 'Thông tin đăng nhập không đúng';

            } else {
                $msgError = current(current($form->getMessages()));
            }
        }

        $view->setVariables(['form' => $form, 'msgError' => $msgError]);

        return $view;
    }
}
