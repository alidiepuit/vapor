<?php

namespace WonderPush\Errors;

/**
 * Network related errors, and API error responses.
 */
class Net extends Base {

  /** @var Request */
  protected $request;

  /** @var Response */
  protected $response;

  public function __construct(\WonderPush\Net\Request $request, \WonderPush\Net\Response $response, $message = "", $code = 0, \Exception $previous = null) {
    parent::__construct($message, $code, $previous);
    $this->request = $request;
    $this->response = $response;
  }

  /**
   * The network request that was performed.
   * @return \WonderPush\Net\Request
   */
  public function getRequest() {
    return $this->request;
  }

  /**
   * The network response that was received.
   * @return \WonderPush\Net\Response
   */
  public function getResponse() {
    return $this->response;
  }

}
