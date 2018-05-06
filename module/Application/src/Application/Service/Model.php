<?php
namespace Application\Service;

class Model {

    private $services;

    public function __construct($services)
    {
        $this->services = $services;
    }

    public function getModel($model)
    {
        return new $model($this->services);
    }

}