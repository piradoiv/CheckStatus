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
  /**
   * Network availability status
   *
   * @var boolean $available
   */
  public $available;

  /**
   * Last timestamp this class checked
   * network availability
   *
   * @var double $lastCheck
   */
  public $lastCheck;

  /**
   * Seconds we will wait until check the
   * status again
   *
   * @var double $recheckAfter
   */
  public $recheckAfter;

  /**
   * The test URL we know it's always online,
   * like Google, Yahoo, Amazon, ...
   *
   * @var string $testUrl
   */
  public $testUrl;

  /**
   * Constructor of the class, we can pass a
   * true on first parameter to call $this->check()
   * on load
   *
   * @param boolean $autocheck
   */
  public function __construct($autocheck = true)
  {
    $this->recheckAfter = 60 * 5; // 5 minutes
    $this->testUrl = 'http://www.google.com/';

    if ($autocheck === true) {
      $this->check();
    }
  }

  /**
   * This method calls checkNetwork() method if,
   * and only if, we waited enough to avoid
   * flooding the testing URL.
   *
   * @return boolean True if available, false otherwise
   */
  public function check()
  {
    $currentTime = microtime(true);
    $expectedTime = $this->lastCheck + $this->recheckAfter;

    if ($currentTime > $expectedTime) {
      $this->lastCheck = microtime(true);
      $this->available = $this->checkNetwork();
    }

    return $this->available;
  }

  /**
   * Checks the network status
   *
   * @return boolean True if available, false otherwise
   * @private
   */
  private function checkNetwork()
  {
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