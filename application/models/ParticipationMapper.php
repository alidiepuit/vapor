<?php

class Application_Model_ParticipationMapper extends Application_Model_BaseModel_BaseMapper
{  
    private static $_sharedInstance = Null;

    protected $_tableName = 'Application_Model_DbTable_Participation';

    static public function getInstance() {
      if (self::$_sharedInstance) {
        return self::$_sharedInstance;
      }
      self::$_sharedInstance = new self();
      return self::$_sharedInstance;
    }

    public function save(Application_Model_Participation $obj)
    {
        $data = array(
            'id'                    => $obj->getId(),
            'enroll_fullname'       => $obj->getEnrollFullname(),
            'enroll_email'          => $obj->getEnrollEmail(),
            'enroll_phone'          => $obj->getEnrollPhone(),
            'enroll_gender'         => $obj->getEnrollGender(),
            'enroll_identifier'     => $obj->getEnrollIdentifier(),
            'enroll_issueby'        => $obj->getEnrollIssueby(),
            'enroll_issueon'        => $obj->getEnrollIssueon(),
            'enroll_address'        => $obj->getEnrollAddress(),
            'enroll_tempaddress'    => $obj->getEnrollTempaddress(),
            'enroll_marital'        => $obj->getEnrollMarital(),
            'enroll_healthy'        => $obj->getEnrollHealthy(),
            'enroll_experience'     => $obj->getEnrollExperience(),
            'enroll_year'           => $obj->getEnrollYear(),
            'enroll_skills'         => $obj->getEnrollSkills(),
            'enroll_tools'          => $obj->getEnrollTools(),
            'enroll_know'           => $obj->getEnrollKnow(),
            'enroll_acceptterms'    => $obj->getEnrollAcceptterms(),
        );
 
        if (null === ($id = $obj->getId())) {
            unset($data['id']);
            $data['created_at'] = date("Y-m-d H:i:s", (int)time());
            $data['updated_at'] = date("Y-m-d H:i:s", (int)time());
            // pr($data);
            $this->getDbTable()->insert($data);
        } else {
            $data['updated_at'] = date("Y-m-d H:i:s", (int)time());
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
}
 
