<?php
namespace Application\Service;

use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
use Zend\Log\Formatter\Simple;

class Writer
{
    private $logger;

    public function write($msg, $type = 'INFO')
    {
        $writerConfig = include 'config/writer.php';

        $fileName = $writerConfig['file_name'] . '.txt';

        $pathConfig = $writerConfig['path'];

        $enable = $writerConfig['enable'];

        switch($type) {

            case 'INFO':
                $function = 'info';
                $path = $pathConfig . '/info/';
                break;

            case 'ERR':
                $function = 'error';
                $path = $pathConfig . '/error/';

            default:
                break;
        }

        if ($enable) {

            if (!is_dir($path)) {
                mkdir($path, 0775, true);
            }

            $path .= $fileName;

            $formatter = new Simple($writerConfig['format']);

            $writer = new Stream($path);
            $writer->setFormatter($formatter);

            $this->logger = new Logger();
            $this->logger->addWriter($writer);

            $this->$function($msg);
        }
    }

    public function info($msg)
    {
        $this->logger->info($msg);
    }

    public function error($msg)
    {
        $this->logger->err($msg);
    }
}