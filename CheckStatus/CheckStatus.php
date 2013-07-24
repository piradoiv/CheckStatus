<?php
/**
 * CheckStatus / CheckStatus
 * =========================
 * This is a library to check the status of a website, it returns if the
 * response is successful, the response time, etc.
 *
 * @package CheckStatus
 * @author  Ricardo Cruz <piradoiv@gmail.com>
 * @link    https://github.com/piradoiv/CheckStatus/
 * @since   0.1.0
 */

namespace CheckStatus;

/**
 * CheckStatus class
 *
 * This is the main class of the library, everything
 * this library can do it will be done from this file
 */
class CheckStatus
{
  public $network;
  public $userAgent;
  public $referer;

  public function __construct()
  {
    $this->network   = new Network;
    $this->userAgent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1468.0 Safari/537.36';
  }

  /**
   * Main method to fetch all of the URL data.
   * @param string $url The URL to fetch
   *
   * @return CheckStatus\Status
   */
  public function fetchUrl($url = null)
  {
    if (!$this->network->check()) {
      throw new NetworkIsDownException;
    }

    if (!$this->isValidUrl($url)) {
      return false;
    }

    $curl = new \Curl();
    $curl->user_agent = $this->userAgent;
    if ($this->referer) {
      $curl->referer = $this->referer;
    }
    $initTime = microtime(true);

    try {
      $response = $curl->get($url);
    } catch(\CurlException $e) {
      $networkAvailable = $this->network->check(true);
      if (!$networkAvailable) {
        throw new NetworkIsDownException;
      }

      $response = false;
    }

    $responseTime = microtime(true) - $initTime; 
    $status = new Status($response);
    $status->setResponseTime($responseTime);
    $status->setUrl($url);

    return $status;
  }

  /**
   * Checks wheter a URL is well formed or not
   * @param string $url
   *
   * @return boolean
   */
  public function isValidUrl($url = null)
  {
    if (!$url) {
      return false;
    }

    $url = $this->prepareUrl($url);
    $parsedUrl = parse_url($url);

    if (!isset($parsedUrl['host'])) {
      return false;
    }

    if (!preg_match("/\./", $parsedUrl['host'])) {
      return false;
    }

    return true;
  }

  /**
   * Prepends http:// string before the URL if
   * isn't present on the string
   * @param string $url
   *
   * @return string
   */
  public static function prepareUrl($url = null)
  {
    $pattern = "/^http(s)?:\/\//";

    if (!preg_match($pattern, $url)) {
      $url = "http://{$url}";
    }

    return $url;
  }
}
