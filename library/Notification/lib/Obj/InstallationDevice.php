<?php

namespace WonderPush\Obj;

/**
 * DTO part for `installation.device`.
 * @see Installation
 * @codeCoverageIgnore
 */
class InstallationDevice extends Object {

  /** @var string */
  private $id;
  /** @var string */
  private $platform;
  /** @var string */
  private $osVersion;
  /** @var string */
  private $brand;
  /** @var string */
  private $model;
  /** @var string */
  private $name;
  /** @var int */
  private $screenWidth;
  /** @var int */
  private $screenHeight;
  /** @var int */
  private $screenDensity;
  /** @var InstallationDeviceCapabilities */
  private $capabilities;
  /** @var InstallationDeviceConfiguration */
  private $configuration;

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
   * @return InstallationDevice
   */
  public function setId($id) {
    $this->id = $id;
    return $this;
  }

  /**
   * @return string
   */
  public function getPlatform() {
    return $this->platform;
  }

  /**
   * @param string $platform
   * @return InstallationDevice
   */
  public function setPlatform($platform) {
    $this->platform = $platform;
    return $this;
  }

  /**
   * @return string
   */
  public function getOsVersion() {
    return $this->osVersion;
  }

  /**
   * @param string $osVersion
   * @return InstallationDevice
   */
  public function setOsVersion($osVersion) {
    $this->osVersion = $osVersion;
    return $this;
  }

  /**
   * @return string
   */
  public function getBrand() {
    return $this->brand;
  }

  /**
   * @param string $brand
   * @return InstallationDevice
   */
  public function setBrand($brand) {
    $this->brand = $brand;
    return $this;
  }

  /**
   * @return string
   */
  public function getModel() {
    return $this->model;
  }

  /**
   * @param string $model
   * @return InstallationDevice
   */
  public function setModel($model) {
    $this->model = $model;
    return $this;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @param string $name
   * @return InstallationDevice
   */
  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  /**
   * @return int
   */
  public function getScreenWidth() {
    return $this->screenWidth;
  }

  /**
   * @param int $screenWidth
   * @return InstallationDevice
   */
  public function setScreenWidth($screenWidth) {
    $this->screenWidth = $screenWidth;
    return $this;
  }

  /**
   * @return int
   */
  public function getScreenHeight() {
    return $this->screenHeight;
  }

  /**
   * @param int $screenHeight
   * @return InstallationDevice
   */
  public function setScreenHeight($screenHeight) {
    $this->screenHeight = $screenHeight;
    return $this;
  }

  /**
   * @return int
   */
  public function getScreenDensity() {
    return $this->screenDensity;
  }

  /**
   * @param int $screenDensity
   * @return InstallationDevice
   */
  public function setScreenDensity($screenDensity) {
    $this->screenDensity = $screenDensity;
    return $this;
  }

  /**
   * @return InstallationDeviceCapabilities
   */
  public function getCapabilities() {
    return $this->capabilities;
  }

  /**
   * @param InstallationDeviceCapabilities|array $capabilities
   * @return InstallationDevice
   */
  public function setCapabilities($capabilities) {
    $this->capabilities = Object::instantiateForSetter('\WonderPush\Obj\InstallationDeviceCapabilities', $capabilities);
    return $this;
  }

  /**
   * @return InstallationDeviceConfiguration
   */
  public function getConfiguration() {
    return $this->configuration;
  }

  /**
   * @param InstallationDeviceConfiguration $configuration
   * @return InstallationDevice
   */
  public function setConfiguration($configuration) {
    $this->configuration = Object::instantiateForSetter('\WonderPush\Obj\InstallationDeviceConfiguration', $configuration);
    return $this;
  }

}
