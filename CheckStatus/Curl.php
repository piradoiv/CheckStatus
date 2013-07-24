<?php
/**
 * CheckStatus / Curl
 * =========================
 * Custom wrapper for PHP native Curl
 *
 * @package CheckStatus
 * @author  Ricardo Cruz <piradoiv@gmail.com>
 * @link    https://github.com/piradoiv/CheckStatus/
 * @since   2.0.0
 */

namespace CheckStatus;

/**
 * Curl class
 *
 * Custom wrapper for PHP native Curl
 */
class Curl
{
  /**
   * Curl handler
   *
   * @var resource $handler
   */
  public $handler;

  /**
   * User Agent to use in requests
   *
   * @var string $userAgent
   */
  public $userAgent;

  /**
   * Proxy to use
   *
   * @var string $proxy
   */
  public $proxy;

  /**
   * Authentication to use, in a
   * username:password form
   *
   * @var string @proxyAuth
   */
  protected $proxyAuth;

  /**
   * Constructor of the class
   */
  public function __construct()
  {
    $this->userAgent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1468.0 Safari/537.36';
  }

  private function prepareHandler($url, $userOptions = array())
  {
    $handler = curl_init($url);
    $options = array(
      CURLOPT_AUTOREFERER => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_MAXREDIRS => 5,
      CURLOPT_USERAGENT => $this->userAgent,
      CURLOPT_NOSIGNAL => true,
      CURLOPT_NOPROGRESS => true,
      CURLOPT_TIMEOUT => 3
    );

    foreach ($userOptions as $key => $value) {
      $options[$key] = $value;
    }

    curl_setopt_array($handler, $options);

    return $handler;
  }

  private function generalRequest($method, $url, $options = array())
  {
    if (strtolower($method) == 'post') {
      $options[CURLOPT_POST] = true;
    }

    if ($this->proxy) {
      $options[CURLOPT_PROXY] = $this->proxy;
    }

    if ($this->proxyAuth) {
      $options[CURLOPT_PROXYAUTH] = $this->proxyAuth;
    }

    $handler = $this->prepareHandler($url, $options);

    $html = curl_exec($handler);

    $response = array(
      'html'    => $html,
      'handler' => $handler
    );

    return $response;
  }

  public function get($url, $options = array())
  {
    return $this->generalRequest('get', $url, $options);
  }

  public function setProxy($proxyString)
  {
    $this->proxy = $proxyString;
  }

  public function setProxyAuth($auth)
  {
    if ($auth) {
      $this->proxyAuth = $auth;
      return true;
    } else {
      return false;
    }
  }

}
