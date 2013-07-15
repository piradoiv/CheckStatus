<?php
/**
 * CheckStatus / Network
 * =========================
 * This is the class on charge to check if the
 * network is currently available or not.
 *
 * @package CheckStatus
 * @author  Ricardo Cruz <piradoiv@gmail.com>
 * @link    https://github.com/piradoiv/CheckStatus/
 * @since   1.3.0
 */

namespace CheckStatus;

/**
 * Network class
 *
 * This is the class on charge to check if the
 * network is currently available or not.
 */
class Network
{
  public $available;
  public $lastCheck;
  public $recheckAfter;
  public $testUrl;

  public function __construct($autocheck = true)
  {
    $this->recheckAfter = 60 * 5; // 5 minutes
    $this->testUrl = 'http://www.google.com/';

    if ($autocheck === true) {
      $this->checkAvailability();
    }
  }

  public function check()
  {
    $currentTime = microtime(true);
    $expectedTime = $this->lastCheck + $this->recheckAfter;

    if ($currentTime > $expectedTime) {
      $this->available = $this->checkNetwork();
    }

    return $this->available;
  }

  public function checkNetwork()
  {
    $this->lastCheck = microtime(true);

    $curl = new \Curl();

    try {
      $curlResponse = $curl->get($this->testUrl);
      $status = new Status($curlResponse);
      if ($status->getCode() == 200) {
        return true;
      } else {
        return false;
      }
    } catch(\CurlException $e) {
      return false;
    }
  }
}
