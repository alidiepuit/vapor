<?php

namespace WonderPush\Obj;

/**
 * DTO part for `installation.preferences`.
 * @see Installation
 * @codeCoverageIgnore
 */
class InstallationPreferences extends Object {

  const SUBSCRIPTION_STATUS_OPTIN = 'optIn';
  const SUBSCRIPTION_STATUS_OPTOUT = 'optOut'; // soft opt-out: we have a push token (and don't want to loose it), but the user wished to disable push notifications

  /** @var string */
  private $subscriptionStatus;

  public function __construct($data = null) {
    parent::__construct($data);
  }

  /**
   * @return string
   */
  public function getSubscriptionStatus() {
    return $this->subscriptionStatus;
  }

  /**
   * @param array $subscriptionStatus
   * @return InstallationPreferences
   */
  public function setSubscriptionStatus($subscriptionStatus) {
    $this->subscriptionStatus = $subscriptionStatus;
    return $this;
  }

}
