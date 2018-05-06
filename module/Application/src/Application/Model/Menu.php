<?php
namespace Application\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class Menu extends Builder
{
    public function __construct($services)
    {
        $this->table    = 'menu';
        $this->primary  = 'menu_id';

        parent::__construct($services);
    }

    public function getMenus($parent = 0, $level = -1, $data = array())
    {
        $result = $this->getMenuLoop($parent, $level, $data);

        return $result;
    }

    public function getMenuLoop($parent = 0, $level = -1, $data = array())
    {
        $result = $this->fetchWhere([
            'WHERE' => 'menu_parent = ' . $parent,
        ]);

        $level++;

        foreach($result as $row) {
            $menu_id = $row[$this->primary];

            $data[$menu_id] = (array) $row;
            $data[$menu_id]['menu_level'] = $level;

            $result = [];
            $result = $this->fetchWhere([
                'WHERE' => 'menu_parent = ' . $menu_id,
            ]);

            if (count($result) > 0) {
                $data = $this->getMenuLoop($menu_id, $level, $data);
            }
        }
        return $data;
    }

}