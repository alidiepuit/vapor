<?php

namespace WonderPush;

/**
 * **WonderPush library entry class.**
 */
class WonderPush implements \Psr\Log\LoggerAwareInterface {

  /**
   * API base URL.
   *
   * Must contain scheme, host and optional port.
   * Can contain an additional path.
   * Must not end with a slash.
   * @see getApiBase()
   * @see getApiRoot()
   */
  const API_BASE = 'https://api.wonderpush.com'; // DO NOT END WITH SLASH

  /**
   * API version.
   * @see getApiRoot()
   */
  const API_VERSION = 'v1'; // "vX", NO SLASH

  /**
   * API prefix.
   * @see getApiRoot()
   */
  const API_PREFIX = '/management'; // DO NOT END WITH SLASH

  /**
   * WonderPush PHP library version.
   */
  const VERSION = '1.0.1-dev';

  /** @var string */
  private $accessToken;
  /** @var string */
  private $applicationId;
  /** @var string */
  private $apiBase;

  /**
   * The logger to which the library will produce messages.
   * @var \Psr\Log\LoggerInterface
   */
  private static $globalLogger;

  /**
   * The logger to which the library will produce messages.
   * @var \Psr\Log\LoggerInterface
   */
  private $logger;

  /**
   * The HttpClient implementation to use.
   * @var Net\HttpClientInterface
   */
  private $httpClient;

  /**
   * Lazily initialized Rest API.
   * @var Api\Rest
   */
  private $rest;

  /**
   * Lazily initialized Deliveries endpoints.
   * @var Api\Deliveries
   */
  private $deliveries;

  /**
   * Constructs the library instance that you can use to send API calls against WonderPush.
   *
   * This is the library entry-point.
   *
   * Relying on an instance instead of a static enables you to easily handle multiple projects,
   * and does not prevent you from creating your own static singleton instance out of it.
   *
   * You can find your credentials in the _Settings_ / _Configuration_ page of {@link https://dashboard.wonderpush.com/ your project dashboard}.
   *
   * @param string $accessToken
   *    The Management API access token used to perform API calls.
   * @param string $applicationId
   *    The application id corresponding to the access token.
   */
  public function __construct($accessToken, $applicationId = null) {
    $this->accessToken = $accessToken;
    $this->applicationId = $applicationId;
  }

  /**
   * The Management API access token used to perform API calls.
   * @return string
   */
  function getAccessToken() {
    return $this->accessToken;
  }

  /**
   * The application id corresponding to the access token.
   * @return string
   */
  function getApplicationId() {
    return $this->applicationId;
  }

  /**
   * The logger to which the library will produce messages, when used outside the scope of a WonderPush instance.
   * @return \Psr\Log\LoggerInterface
   */
  public static function getGlobalLogger() {
    return self::$globalLogger;
  }

  /**
   * Set the logger to which the library will produce messages, when used outside the scope of a WonderPush instance.
   * @param \Psr\Log\LoggerInterface $logger
   */
  public static function setGlobalLogger(\Psr\Log\LoggerInterface $logger) {
    self::$globalLogger = $logger;
  }

  /**
   * The logger to which the library will produce messages.
   * @return \Psr\Log\LoggerInterface
   */
  public function getLogger() {
    return $this->logger ?: self::getGlobalLogger();
  }

  /**
   * Set the logger to which the library will produce messages.
   * @param \Psr\Log\LoggerInterface $logger
   */
  public function setLogger(\Psr\Log\LoggerInterface $logger) {
    $this->logger = $logger;
  }

  /**
   * The HTTP client to use to perform API calls.
   * @return Net\HttpClientInterface
   */
  public function getHttpClient() {
    if ($this->httpClient === null) {
      $this->httpClient = new Net\CurlHttpClient($this);
    }
    return $this->httpClient;
  }

  /**
   * Set the HTTP client to use to perform API calls.
   * @param \WonderPush\Net\HttpClientInterface $httpClient
   */
  public function setHttpClient(Net\HttpClientInterface $httpClient) {
    $this->httpClient = $httpClient;
  }

  /**
   * The API base against which to place API calls.
   * 
   * This is mostly useful for developing the PHP library itself, you should ignore it.
   *
   * @return string
   * @see API_BASE
   */
  public function getApiBase() {
    return $this->apiBase ?: self::API_BASE;
  }

  /**
   * The API base against which to place API calls.
   *
   * This is mostly useful for developing the PHP library itself, you should ignore it.
   *
   * @param string $apiBase
   */
  public function setApiBase($apiBase) {
    $this->apiBase = $apiBase;
  }

  /**
   * The API root against which to place API calls.
   *
   * Builds on the API base, API version and API prefix.
   *
   * @return string
   * @see getApiBase()
   * @see API_VERSION
   * @see API_PREFIX
   */
  public function getApiRoot() {
    return $this->getApiBase() . '/' . self::API_VERSION . self::API_PREFIX;
  }

  /**
   * Rest API instance.
   * @return Api\Rest
   */
  public function rest() {
    if ($this->rest === null) {
      $this->rest = new Api\Rest($this);
    }
    return $this->rest;
  }

  /**
   * Deliveries endpoints.
   * @return Api\Deliveries
   */
  public function deliveries() {
    if ($this->deliveries === null) {
      $this->deliveries = new Api\Deliveries($this);
    }
    return $this->deliveries;
  }

}

WonderPush::setGlobalLogger(new Util\DefaultLogger());
