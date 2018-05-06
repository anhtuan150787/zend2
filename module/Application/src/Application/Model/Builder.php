<?php
namespace Application\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class Builder {

    protected $tableGateway;
    protected $dbAdapter;
    protected $services;
    protected $cache;
    protected $tableView;

    public $table;
    public $primary;

    public function __construct($services)
    {
        $this->services = $services;
        $this->dbAdapter = $this->services->get('Zend/Db/Adapter/Adapter');
        $this->tableGateway = new TableGateway($this->table, $this->dbAdapter);
    }

    public function fetchPrimary($primaryId)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->primary . '=' . $primaryId;

        return $this->getRow($sql);
    }


    public function fetchRow($options)
    {
        $sql = $this->getSql($options);

        return $this->getRow($sql);
    }

    public function fetchWhere($options)
    {
        $sql = $this->getSql($options);

        return $this->getFetch($sql);
    }

    public function getSql($options)
    {
        $sql = 'SELECT';

        $columns = ' * ';
        if ($options['COLUMNS']) {
            $columns = ' ' . $options['COLUMNS'];
        }

        $from = ' FROM ' . $this->table;
        if ($options['FROM']) {
            $from = ' FROM ' . $options['FROM'];
        }

        $join = ' ';
        if ($options['JOIN']) {
            $join = ' ' . $options['JOIN'] . ' ';
        }

        $where = ' WHERE 1=1 ';
        if ($options['WHERE']) {
            $where .= ' AND ' . $options['WHERE'];
        }

        $sql .= $columns . $from . $join . $where;

        return $sql;
    }

    public function getRow($sql)
    {
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $result = $statement->execute();

        return $result->current();
    }

    public function getFetch($sql)
    {
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $result = $statement->execute();

        $data = [];
        foreach($result as $k => $v) {
            $data[$k] = $v;
        }

        return $data;
    }
}