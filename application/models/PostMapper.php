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
            'post_sub_content'      => $obj->getPostSubContent(),
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
                    ->where('post_type = ?', (int)$type)
                    ->where('deleted_at IS NULL');
            // echo $select;die;
            $services = $this->getDbTable()->fetchAll($select);
            $services = $services ? $services->toArray() : Null;
            $res = array();
            foreach ($services as $val) {
                $res[] = new Application_Model_Post($val);
            }
            return $res;
        } catch (Exception $e) {
            pr($e);
        }
    }

    public function getPostBySlug($slug)
    {
        try {
            $select = $this->getDbTable()->select()
                    ->from('frontend_posts')
                    ->where('post_slug LIKE ?', $slug)
                    ->where('deleted_at IS NULL');

            $row = $this->getDbTable()->fetchRow($select);
            $row = $row ? $row->toArray() : Null;
            $res = new Application_Model_Post($row);
            $res->setPostUpdateTime($row['updated_at']);
            return $res;
        } catch (Exception $e) {
            pr($e);
        }
        return Null;
    }

    public function getPostById($id)
    {
        try {
            $select = $this->getDbTable()->select()
                    ->from('frontend_posts')
                    ->where('id = ?', (int)$id)
                    ->where('deleted_at IS NULL');

            $row = $this->getDbTable()->fetchRow($select);
            $row = $row ? $row->toArray() : Null;
            $res = new Application_Model_Post($row);
            $res->setPostUpdateTime($row['updated_at']);
            return $res;
        } catch (Exception $e) {
            pr($e);
        }
        return Null;
    }

    public function getListArticle($offset, $limit)
    {
        try {
            $select = $this->getDbTable()->select()
                    ->from('frontend_posts')
                    ->where('deleted_at IS NULL')
                    ->where('post_type = ?', Application_Model_Post::POST_TYPE_ARTICLE)
                    ->limitPage($offset, $limit)
                    ->order(array('updated_at DESC'));

            $rows = $this->getDbTable()->fetchAll($select);
            $rows = $rows ? $rows->toArray() : Null;
            $res = array();
            foreach($rows as $row) {
                // pr($row);
                $post = new Application_Model_Post($row);
                $post->setPostUpdateTime($row['updated_at']);
                // pr($post->setPostUpdateTime($row['updated_at']));
                $res[] = $post;
            }
            
            return $res;
        } catch (Exception $e) {
            pr($e);
        }
        return Null;
    }
}
