<?php
class Application_Model_Vote extends Application_Model_BaseModel_BaseModel
{
  protected $_voteId;
  protected $_voteGrouporderId;
  protected $_voteStar;
  protected $_voteComment;
  protected $_voteUser;

  public function setId($text)
  {
      $this->_voteId = (int) $text;
      return $this;
  }

  public function getId()
  {
      return $this->_voteId;
  }

  public function setVoteGrouporder($text)
  {
      $this->_voteGrouporderId = (int) $text;
      return $this;
  }

  public function getVoteGrouporder()
  {
      return $this->_voteGrouporderId;
  }

  public function setVoteStar($text)
  {
      $this->_voteStar = (int) $text;
      return $this;
  }

  public function getVoteStar()
  {
      return $this->_voteStar;
  }

  public function setVoteComment($text)
  {
      $this->_voteComment = (string) $text;
      return $this;
  }

  public function getVoteComment()
  {
      return $this->_voteComment;
  }

  public function setVoteUser($text)
  {
      $this->_voteUser = (string) $text;
      return $this;
  }

  public function getVoteUser()
  {
      return $this->_voteUser;
  }
}
