<?php

namespace WonderPush\Obj;

/**
 * DTO part for `installation.application`.
 * @see Installation
 * @codeCoverageIgnore
 */
class InstallationApplication extends Object {

  /** @var string */
  private $id;
  /** @var string */
  private $version;
  /** @var string */
  private $sdkVersion;
  /** @var string */
  private $domain;
  /** @var InstallationApplicationApple */
  private $apple;

  public function __construct($data = null) {
    parent::__construct($data);
  }

  /**
   * @return string
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @param string $id
   * @return InstallationApplication
   */
  public function setId($id) {
    $this->id = $id;
    return $this;
  }

  /**
   * @return string
   */
  public function getVersion() {
    return $this->version;
  }

  /**
   * @param string $version
   * @return InstallationApplication
   */
  public function setVersion($version) {
    $this->version = $version;
    return $this;
  }

  /**
   * @return string
   */
  public function getSdkVersion() {
    return $this->sdkVersion;
  }

  /**
   * @param string $sdkVersion
   * @return InstallationApplication
   */
  public function setSdkVersion($sdkVersion) {
    $this->sdkVersion = $sdkVersion;
    return $this;
  }

  /**
   * @return string
   */
  public function getDomain() {
    return $this->domain;
  }

  /**
   * @param string $domain
   * @return InstallationApplication
   */
  public function setDomain($domain) {
    $this->domain = $domain;
    return $this;
  }

  /**
   * @return InstallationApplicationApple
   */
  public function getApple() {
    return $this->apple;
  }

  /**
   * @param InstallationApplicationApple $apple
   * @return InstallationApplication
   */
  public function setApple($apple) {
    $this->apple = Object::instantiateForSetter('\WonderPush\Obj\InstallationApplicationApple', $apple);
    return $this;
  }

}
