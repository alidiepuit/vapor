<?php

class Application_Model_VoteMapper extends Application_Model_BaseModel_BaseMapper
{  

    private static $_sharedInstance = Null;

    protected $_tableName = 'Application_Model_DbTable_Vote';

    static public function getInstance() {
      if (self::$_sharedInstance) {
        return self::$_sharedInstance;
      }
      self::$_sharedInstance = new self();
      return self::$_sharedInstance;
    }

    public function save(Application_Model_Vote $obj)
    {
        $data = array(
            'id'                        => $obj->getId(),
            'vote_grouporder'           => $obj->getVoteGrouporder(),
            'vote_star'                 => $obj->getVoteStar(),
            'vote_comment'              => $obj->getVoteComment(),
            'vote_user'                 => $obj->getVoteUser(),
        );
 
        if (null === ($id = $obj->getId())) {
            unset($data['id']);
            // pr($data);
            $id = $this->getDbTable()->insert($data);
            return $id;
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
}
 