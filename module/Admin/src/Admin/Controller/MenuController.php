<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MenuController extends MainController
{
    public function __construct()
    {
        $this->moduleName = 'Menu';
        $this->module = 'menu';
        $this->modelClass = 'Application\Model\Menu';
        $this->status = ['1' => 'Kích hoạt', '0' => 'Tạm dừng'];
    }

    public function indexAction()
    {
        $this->init();

        $records = $this->model->getMenus();

        $this->view->setVariables([
            'records' => $records,
            'status' => $this->status,
        ]);

        return $this->view;
    }
}
