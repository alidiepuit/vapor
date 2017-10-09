<?php

class Application_Model_PostMapper extends Application_Model_BaseModel_BaseMapper
{  
    private static $_sharedInstance = Null;

    protected $_tableName = 'Application_Model_DbTable_Post';

    static public function getInstance() {
      if (self::$_sharedInstance) {
        return self::$_sharedInstance;
      }
      self::$_sharedInstance = new self();
      return self::$_sharedInstance;
    }

    public function save(Application_Model_Post $obj)
    {
        $data = array(
            'post_id'               => $obj->getPostId(),
            'post_title'            => $obj->getPostTitle(),
            'post_slug'             => $obj->getPostSlug(),
            'post_content'          => $obj->getPostContent(),
            'created_at'            => $obj->getPostCreateTime(),
            'updated_at'            => $obj->getPostUpdateTime(),
            'post_create_by'        => $obj->getPostCreateBy(),
            'post_image'            => $obj->getPostImage(),
            'post_type'             => $obj->getPostType(),
        );
 
        if (null === ($id = $obj->getPostId())) {
            unset($data['post_id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('post_id = ?' => $id));
        }
    }
 
    public function getPostByType($type)
    {
        try {
            $select = $this->getDbTable()->select()
                    ->from('frontend_posts')
                    ->order('updated_at DESC')
                    ->where('post_type = ?', (int)$type);

            $services = $this->getDbTable()->fetchAll($select);
            $services = $services->toArray();
            $res = array();
            foreach ($services as $val) {
                $res[] = new Application_Model_Post($val);
            }
            return $res;
        } catch (Exception $e) {
            pr($e);
        }
    }
}
