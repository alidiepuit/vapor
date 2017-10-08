<?php
class Application_Model_Post extends Application_Model_BaseModel_BaseModel
{
    const POST_TYPE_ARTICLE     = 0;
    const POST_TYPE_SERVICE     = 1;
    const POST_TYPE_FEATURE     = 2;
    const POST_TYPE_CUSTOMER    = 3;

    protected $_postId;
    protected $_postTitle;
    protected $_postSlug;
    protected $_postContent;
    protected $_postCreateTime;
    protected $_postUpdateTime;
    protected $_postCreateBy;
    protected $_postImage;
    protected $_postType;
 
    public function setPostId($text)
    {
        $this->_postId = (string) $text;
        return $this;
    }
 
    public function getPostId()
    {
        return $this->_postId;
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
        return $this->_postSlug;
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
 
}