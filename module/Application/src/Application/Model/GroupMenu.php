<?php
namespace Application\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class GroupMenu extends Builder
{
    public function __construct($services)
    {
        $this->table    = 'group_menu';
        $this->primary  = 'group_menu_id';

        parent::__construct($services);
    }

    public function getGroupMenu($group_admin_id, $parent = 0, $level = -1, $data = array())
    {
        $result = $this->getGroupMenuList($group_admin_id, $parent, $level, $data);

        return $result;
    }

    public function getGroupMenuList($group_admin_id, $parent = 0, $level = -1, $data = array())
    {
        $result = $this->fetchWhere([
            'JOIN'  => 'LEFT JOIN menu ON menu.menu_id=group_menu.menu_id',
            'WHERE' => 'group_account_id = ' . $group_admin_id . '
                        AND group_menu_status = 1
                        AND menu_parent = ' . $parent,
            'ORDER' => 'menu_position ASC, menu.menu_id ASC',
        ]);

        $level++;

        foreach($result as $row) {

            $menu_id = $row['menu_id'];

            $data[$menu_id] = (array) $row;
            $data[$menu_id]['menu_level'] = $level;

            $result = [];
            $result = $this->fetchWhere([
                'JOIN'  => 'LEFT JOIN menu ON menu.menu_id=group_menu.menu_id',
                'WHERE' => 'group_account_id = ' . $group_admin_id . '
                            AND group_menu_status = 1
                            AND menu_parent = ' . $menu_id,
                'ORDER' => 'ORDER BY menu_position ASC, menu.menu_id ASC',
            ]);

            if (count($result) > 0) {
                $data = $this->getGroupMenuList($group_admin_id, $menu_id, $level, $data);
            }
        }
        return $data;
    }

}