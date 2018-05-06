<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

class MainController extends AbstractActionController
{
    protected $module;
    protected $moduleName;
    protected $modelClass;
    protected $model;
    protected $view;

    public function onDispatch(MvcEvent $e)
    {
        $auth = new AuthenticationService();

        if (!$auth->hasIdentity()) {
            $this->redirect()->toRoute('admin/default', array('controller' => 'login', 'action' => 'index'));
        } else {
            $this->user = $auth->getIdentity();
        }

        $this->layout('layout/admin');

        $groupMenuModel = $e->getApplication()->getServiceManager()->get('Model')->getModel('Application\Model\GroupMenu');
        $menu = $groupMenuModel->getGroupMenu($this->user->group_account_id);

        $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
        $viewModel->user = $this->user;
        $viewModel->menu = $menu;

        return parent::onDispatch($e);
    }

    public function init()
    {
        $this->model = $this->getServiceLocator()->get('Model')->getModel($this->modelClass);

        $this->view = new ViewModel();

        $this->view->setVariables([
            'module' => $this->module,
            'moduleName' => $this->moduleName
        ]);
    }
}
