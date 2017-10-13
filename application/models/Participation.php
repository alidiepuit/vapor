<?php
class Application_Model_Participation extends Application_Model_BaseModel_BaseModel
{

    protected $_id;
    protected $_enrollFullname;
    protected $_enrollEmail;
    protected $_enrollPhone;
    protected $_enrollGender;
    protected $_enrollIdentifier;
    protected $_enrollIssueby;
    protected $_enrollIssueon;
    protected $_enrollAddress;
    protected $_enrollTempaddress;
    protected $_enrollMarital;
    protected $_enrollHealthy;
    protected $_enrollExperience;
    protected $_enrollYear;
    protected $_enrollSkills;
    protected $_enrollTools;
    protected $_enrollKnow;
    protected $_enrollAcceptterms;
    
    public function setId($text)
    {
        $this->_id = (string) $text;
        return $this;
    }
 
    public function getId()
    {
        return $this->_id;
    }    

    public function setEnrollFullname($text)
    {
        $this->_enrollFullname = (string) $text;
        return $this;
    }
 
    public function getEnrollFullname()
    {
        return $this->_enrollFullname;
    }  

    public function setEnrollEmail($text)
    {
        $this->_enrollEmail = (string) $text;
        return $this;
    }
 
    public function getEnrollEmail()
    {
        return $this->_enrollEmail;
    }  

    public function setEnrollPhone($text)
    {
        $this->_enrollPhone = (string) $text;
        return $this;
    }
 
    public function getEnrollPhone()
    {
        return $this->_enrollPhone;
    }  

    public function setEnrollGender($text)
    {
        $this->_enrollGender = (string) $text;
        return $this;
    }
 
    public function getEnrollGender()
    {
        return $this->_enrollGender;
    }  

    public function setEnrollIdentifier($text)
    {
        $this->_enrollIdentifier = (string) $text;
        return $this;
    }
 
    public function getEnrollIdentifier()
    {
        return $this->_enrollIdentifier;
    }  

    public function setEnrollIssueby($text)
    {
        $this->_enrollIssueby = (string) $text;
        return $this;
    }
 
    public function getEnrollIssueby()
    {
        return $this->_enrollIssueby;
    }  

    public function setEnrollIssueon($text)
    {
        $this->_enrollIssueon = (string) $text;
        return $this;
    }
 
    public function getEnrollIssueon()
    {
        return $this->_enrollIssueon;
    }  

    public function setEnrollAddress($text)
    {
        $this->_enrollAddress = (string) $text;
        return $this;
    }
 
    public function getEnrollAddress()
    {
        return $this->_enrollAddress;
    }  

    public function setEnrollTempaddress($text)
    {
        $this->_enrollTempaddress = (string) $text;
        return $this;
    }
 
    public function getEnrollTempaddress()
    {
        return $this->_enrollTempaddress;
    }  

    public function setEnrollMarital($text)
    {
        $this->_enrollMarital = (string) $text;
        return $this;
    }
 
    public function getEnrollMarital()
    {
        return $this->_enrollMarital;
    }  

    public function setEnrollHealthy($text)
    {
        $this->_enrollHealthy = (string) $text;
        return $this;
    }
 
    public function getEnrollHealthy()
    {
        return $this->_enrollHealthy;
    }  

    public function setEnrollExperience($text)
    {
        $this->_enrollExperience = (string) $text;
        return $this;
    }
 
    public function getEnrollExperience()
    {
        return $this->_enrollExperience;
    }  

    public function setEnrollYear($text)
    {
        $this->_enrollYear = (string) $text;
        return $this;
    }
 
    public function getEnrollYear()
    {
        return $this->_enrollYear;
    }  

    public function setEnrollSkills($text)
    {
        $this->_enrollSkills = (string) $text;
        return $this;
    }
 
    public function getEnrollSkills()
    {
        return $this->_enrollSkills;
    }  

    public function setEnrollTools($text)
    {
        $this->_enrollTools = (string) $text;
        return $this;
    }
 
    public function getEnrollTools()
    {
        return $this->_enrollTools;
    }  

    public function setEnrollKnow($text)
    {
        $this->_enrollKnow = (string) $text;
        return $this;
    }
 
    public function getEnrollKnow()
    {
        return $this->_enrollKnow;
    }  

    public function setEnrollAcceptterms($text)
    {
        $this->_enrollAcceptterms = (string) $text;
        return $this;
    }
 
    public function getEnrollAcceptterms()
    {
        return $this->_enrollAcceptterms;
    }
}