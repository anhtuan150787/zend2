<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

class LogoutController extends AbstractActionController
{
    public function indexAction()
    {
        $auth =  new AuthenticationService();
        $user = $auth->getIdentity();
        $auth->clearIdentity();

        $this->redirect()->toRoute('admin/default', array('controller' => 'login', 'action' => 'index'));
        return $this->response;
    }
}
