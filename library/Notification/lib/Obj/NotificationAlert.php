<?php

namespace WonderPush\Obj;

/**
 * DTO part for `notification.alert`.
 * @see Notification
 * @codeCoverageIgnore
 */
class NotificationAlert extends Object {

  /** @var string */
  protected $text;
  /** @var string */
  protected $title;
  /** @var string */
  protected $targetUrl;
  /** @var NotificationButtonAction[] */
  protected $actions; // at open
  /** @var NotificationButtonAction[] */
  protected $receiveActions; // at reception
  /** @var NotificationAlertIos */
  protected $ios;
  /** @var NotificationAlertAndroid */
  protected $android;
  /** @var NotificationAlertWeb */
  protected $web;

  /**
   * @return string
   */
  public function getText() {
    return $this->text;
  }

  /**
   * @param string $text
   * @return NotificationAlert
   */
  public function setText($text) {
    $this->text = $text;
    return $this;
  }

  /**
   * @return string
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * @param string $title
   * @return NotificationAlert
   */
  public function setTitle($title) {
    $this->title = $title;
    return $this;
  }

  /**
   * @return string
   */
  public function getTargetUrl() {
    return $this->targetUrl;
  }

  /**
   * @param string $targetUrl
   * @return NotificationAlert
   */
  public function setTargetUrl($targetUrl) {
    $this->targetUrl = $targetUrl;
    return $this;
  }

  /**
   * @return NotificationButtonAction[]
   */
  public function getActions() {
    return $this->actions;
  }

  /**
   * @param NotificationButtonAction[]|array[] $actions
   * @return NotificationAlert
   */
  public function setActions($actions) {
    $this->actions = Object::instantiateForSetter('\WonderPush\Obj\NotificationButtonAction[]', $actions);
    return $this;
  }

  /**
   * @return NotificationButtonAction[]
   */
  public function getReceiveActions() {
    return $this->receiveActions;
  }

  /**
   * @param NotificationButtonAction[]|array[] $receiveActions
   * @return NotificationAlert
   */
  public function setReceiveActions($receiveActions) {
    $this->receiveActions = Object::instantiateForSetter('\WonderPush\Obj\NotificationButtonAction[]', $receiveActions);
    return $this;
  }

  /**
   * @return NotificationAlertIos
   */
  public function getIos() {
    return $this->ios;
  }

  /**
   * @param NotificationAlertIos|array $ios
   * @return NotificationAlert
   */
  public function setIos($ios) {
    $this->ios = Object::instantiateForSetter('\WonderPush\Obj\NotificationAlertIos', $ios);
    return $this;
  }

  /**
   * @return NotificationAlertAndroid
   */
  public function getAndroid() {
    return $this->android;
  }

  /**
   * @param NotificationAlertAndroid|array $android
   * @return NotificationAlert
   */
  public function setAndroid($android) {
    $this->android = Object::instantiateForSetter('\WonderPush\Obj\NotificationAlertAndroid', $android);
    return $this;
  }

  /**
   * @return NotificationAlertWeb
   */
  public function getWeb() {
    return $this->web;
  }

  /**
   * @param NotificationAlertWeb|array $web
   * @return NotificationAlert
   */
  public function setWeb($web) {
    $this->web = Object::instantiateForSetter('\WonderPush\Obj\NotificationAlertWeb', $web);
    return $this;
  }

}
