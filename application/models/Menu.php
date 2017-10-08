<?php
class Application_Model_Menu extends Application_Model_BaseModel_BaseModel
{
    const MENU_POSITION_TOP = 0;
    const MENU_POSITION_BOTTOM = 1;

    protected $_menuId;
    protected $_menuPosition;
    protected $_menuParentId;
    protected $_menuTitle;
    protected $_menuLink;
    protected $_menuAction;
 
    public function setMenuId($text)
    {
        $this->_menuId = (string) $text;
        return $this;
    }
 
    public function getMenuId()
    {
        return $this->_menuId;
    }
 
    public function setMenuPosition($text)
    {
        $this->_menuPosition = (string) $text;
        return $this;
    }
 
    public function getMenuPosition()
    {
        return $this->_menuPosition;
    }
 
    public function setMenuParentId($text)
    {
        $this->_menuParentId = (string) $text;
        return $this;
    }
 
    public function getMenuParentId()
    {
        return $this->_menuParentId;
    }
 
    public function setMenuTitle($text)
    {
        $this->_menuTitle = (string) $text;
        return $this;
    }
 
    public function getMenuTitle()
    {
        return $this->_menuTitle;
    }
 
    public function setMenuLink($text)
    {
        $this->_menuLink = (string) $text;
        return $this;
    }
 
    public function getMenuLink()
    {
        return $this->_menuLink;
    }
 
    public function setMenuAction($text)
    {
        $this->_menuAction = (string) $text;
        return $this;
    }
 
    public function getMenuAction()
    {
        return $this->_menuAction;
    }
 
}