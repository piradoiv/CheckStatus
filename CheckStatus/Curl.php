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
   * Constructor of the class
   */
  public function __construct()
  {
    $this->userAgent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1468.0 Safari/537.36';
  }

  private function prepareHandler($url, $options = array())
  {
    $handler = curl_init($url);
    $defaultOptions = array(
      CURLOPT_AUTOREFERER => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_MAXREDIRS => 5,
      CURLOPT_USERAGENT => $this->userAgent,
    );

    $options = array_merge($defaultOptions, $options);

    curl_setopt_array($handler, $options);

    return $handler;
  }

  private function generalRequest($method, $url, $options = array())
  {
    if (strtolower($method) == 'post') {
      $options[CURLOPT_POST] = true;
    }

    $handler = $this->prepareHandler($url, $options);
    $html = curl_exec($handler);
    $status = new Status($handler, $html);

    return $status;
  }

  public function get($url, $options = array())
  {
    return $this->generalRequest('get', $url, $options);
  }

}
