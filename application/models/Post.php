<?php
class Application_Model_Post extends Application_Model_BaseModel_BaseModel
{
    const POST_TYPE_ARTICLE     = 1;
    const POST_TYPE_SERVICE     = 2;
    const POST_TYPE_FEATURE     = 3;
    const POST_TYPE_CUSTOMER    = 4;
    const POST_TYPE_TERM        = 5;

    protected $_id;
    protected $_postTitle;
    protected $_postSlug;
    protected $_postContent;
    protected $_postCreateTime;
    protected $_postUpdateTime;
    protected $_postCreateBy;
    protected $_postImage;
    protected $_postType;
    protected $_postSubContent;
 
    public function setId($text)
    {
        $this->_id = (string) $text;
        return $this;
    }
 
    public function getId()
    {
        return $this->_id;
    }
 
    public function setPostTitle($text)
    {
        $this->_postTitle = (string) $text;
        return $this;
    }
 
    public function getPostTitle()
    {
        return $this->_postTitle;
    }
 
    public function setPostSlug($text)
    {
        $this->_postSlug = (string) $text;
        return $this;
    }
 
    public function getPostSlug()
    {
        return !$this->_postSlug ? $this->slugify($this->_postTitle) : $this->_postSlug;
    }
 
    public function setPostContent($text)
    {
        $this->_postContent = (string) $text;
        return $this;
    }
 
    public function getPostContent()
    {
        return $this->_postContent;
    }
 
    public function setPostCreateTime($text)
    {
        $this->_postCreateTime = (string) $text;
        return $this;
    }
 
    public function getPostCreateTime()
    {
        return $this->_postCreateTime;
    }
 
    public function setPostUpdateTime($text)
    {
        $this->_postUpdateTime = (string) $text;
        return $this;
    }
 
    public function getPostUpdateTime()
    {
        return $this->_postUpdateTime;
    }
 
    public function setPostCreateBy($text)
    {
        $this->_postCreateBy = (string) $text;
        return $this;
    }
 
    public function getPostCreateBy()
    {
        return $this->_postCreateBy;
    }
 
    public function setPostImage($text)
    {
        $this->_postImage = (string) $text;
        return $this;
    }
 
    public function getPostImage()
    {
        return $this->_postImage;
    }
 
    public function setPostType($text)
    {
        $this->_postType = (string) $text;
        return $this;
    }
 
    public function getPostType()
    {
        return $this->_postType;
    }
 
    public function setPostSubContent($text)
    {
        $this->_postSubContent = (string) $text;
        return $this;
    }
 
    public function getPostSubContent()
    {
        return $this->_postSubContent;
    }
 
}