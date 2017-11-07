<?php

class Application_Model_MenuMapper extends Application_Model_BaseModel_BaseMapper
{  

    private static $_sharedInstance = Null;

    protected $_tableName = 'Application_Model_DbTable_Menu';

    static public function getInstance() {
      if (self::$_sharedInstance) {
        return self::$_sharedInstance;
      }
      self::$_sharedInstance = new self();
      return self::$_sharedInstance;
    }

    public function save(Application_Model_Menu $obj)
    {
        $data = array(
            'id'               => $obj->getMenuId(),
            'menu_position'         => $obj->getMenuPosition(),
            'menu_parent_id'        => $obj->getMenuParentId(),
            'menu_title'            => $obj->getMenuTitle(),
            'menu_link'             => $obj->getMenuLink(),
            'menu_action'           => $obj->getMenuAction(),
        );
 
        if (null === ($id = $obj->getMenuId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function getMenu($position)
    {
        try {
            $select = $this->getDbTable()->select()
                ->from(array('parent' => 'frontend_menu_items'), array(
                    'parent_id'         => 'parent.id',
                    'parent_title'      => 'parent.menu_title',
                    'parent_link'       => 'parent.menu_link',
                    'parent_action'     => 'parent.menu_action',
                    'child_id'          => 'child.id',
                    'child_title'       => 'child.menu_title',
                    'child_link'        => 'child.menu_link',
                    'child_action'      => 'child.menu_action',
                ))
                ->joinLeft(
                        array('child' => 'frontend_menu_items'),
                        'child.menu_parent_id = parent.id',
                        array()
                    )
                ->order('parent_id ASC')
                ->where('parent.menu_position = ? AND parent.menu_parent_id = parent.id', (int)$position)
                ->where('parent.deleted_at IS NULL');
            // echo $select;die;
            $result = $this->getDbTable()->fetchAll($select);
            // pr($result);
            
            $data = array();
            foreach ($result as $row) {
                if (!isset($data[$row['parent_id']])) {
                    $data[$row['parent_id']] = array(
                        'parent' => new Application_Model_Menu(array(
                            'menu_title'  => $row['parent_title'],
                            'menu_link'   => $row['parent_link'],
                            'menu_action' => $row['parent_action'],
                        )),
                        'child' => array(),
                    );
                }
                if ($row['child_id'] != $row['parent_id']) {
                    $data[$row['parent_id']]['child'][] = new Application_Model_Menu(array(
                            'menu_title'       => $row['child_title'],
                            'menu_link'        => $row['child_link'],
                            'menu_action'      => $row['child_action'],
                        ));
                }
                
            }

            // pr($data);
            return $data;

        } catch (Exception $e) {
            pr($e);
            return array();
        }
    }
}
