<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Service\Model;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        ini_set('date.timezone', 'Asia/Ho_Chi_Minh');

        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        /*
         *  Dispatch error, render error
         *  Apply for all system
         */
        $eventManager->attach(['dispatch.error', 'render.error'], function (MvcEvent $e) {

            $writer = $e->getApplication()->getServiceManager()->get('Writer');

            $errorMsg = [];

            array_push($errorMsg, $e->getError());

            if ($request = $e->getRequest()) {
                array_push($errorMsg, $request->getServer('REMOTE_ADDR'), $request->getServer('HTTP_USER_AGENT'), $request->getServer('HTTP_REFERER'), $request->getMethod(), $request->getUriString());
            }

            $exception = $e->getResult()->exception;

            if ($exception instanceof \Exception) {
                array_push($errorMsg, $exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
            }

            $writer->write(implode("\t", $errorMsg), 'ERR');
        });
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Model' => function($sm) {
                    return new Model($sm);
                },
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
