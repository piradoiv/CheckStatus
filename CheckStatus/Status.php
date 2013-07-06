<?php
/**
 * CheckStatus / Status
 * =========================
 * This is the class it will be returned when the user
 * asks for fetchUrl, on CheckStatus class 
 *
 * @package CheckStatus
 * @author  Ricardo Cruz <piradoiv@gmail.com>
 * @link    https://github.com/piradoiv/CheckStatus/
 * @since   0.1.0
 */

namespace CheckStatus;

/**
 * Status class
 *
 * Response code, response time, timestamp... every useful
 * information on the request will be returned with this
 * class
 */
class Status
{
  /**
   * @param \Curl\Response $_response
   * @private
   */
  private $_response;

  /**
   * @param integer $_code
   * @private
   */
  private $_code;

  /**
   * @param integer $_responseTime
   * @private
   */
  private $_responseTime;

  /**
   * @param boolean $_success
   * @private
   */
  private $_success;

  /**
   * @param string $_url
   * @private
   */
  private $_url;

  /**
   * @param string $_timestamp
   * @private
   */
  private $_timestamp;

  /**
   * Constructor of the class
   * @param \Curl\CurlResponse
   *
   * @return array Summary of the response
   */
  public function __construct($response = null)
  {
    $this->_response = $response;
    $this->_timestamp = time();

    return $this->getSummary();
  }

  /**
   * getCode()
   * Returns the status code of the request, for example
   * a 200 code is a success response
   *
   * @return integer
   */
  public function getCode()
  {
    if (!$this->_code) {
      $this->_code = $this->_response->headers['Status-Code'];
    }

    return $this->_code;
  }

  /**
   * getResponseTime()
   * Returns the response time, in milliseconds
   *
   * @return integer
   */
  public function getResponseTime()
  {
    if (gettype($this->_responseTime) == 'double') {
      $this->_responseTime *= 1000;
      settype($this->_responseTime, 'integer');
    }

    return $this->_responseTime;
  }

  /**
   * getSummary()
   * Returns a summary array with the success status,
   * response time in milliseconds, the url and timestamp
   *
   * @return array
   */
  public function getSummary()
  {
    if ($this->_response instanceof \CurlResponse) {
      $summary = array(
        'success' => $this->isSuccess(),
        'failure' => $this->isFailure(),
        'responseTime' => $this->getResponseTime(),
        'url' => $this->getUrl(),
        'timestamp' => $this->getTimestamp()
      );

    } else {
      $summary = array(
        'success' => false,
        'failure' => true,
        'responseTime' => -1,
        'url' => $this->getUrl(),
        'timestamp' => $this->getTimestamp()
      );
    }
    

    return $summary;
  }

  /**
   * getUrl()
   * Returns the URL used to generate the summary
   *
   * @return string
   */
  public function getUrl()
  {
    if (isset($this->_url)) {
      $url = CheckStatus::prepareUrl($this->_url);
    } else {
      $url = null;
    }

    return $url;
  }

  /**
   * getTimestamp()
   * Returns the timestamp of the request
   *
   * @return integer
   */
  public function getTimestamp()
  {
    return $this->_timestamp;
  }

  /**
   * setUrl()
   * Sets the URL used to generate the summary
   *
   * @return boolean
   */
  public function setUrl($url = null)
  {
    if (!$url) {
      return false;
    }

    $this->_url = $url;

    return true;
  }

  /**
   * setResponseTime()
   * Sets how many milliseconds took to fetch the URL
   *
   * @return void
   */
  public function setResponseTime($time)
  {
    $this->_responseTime = $time;
  }

  /**
   * isSuccess()
   * Returns if the response code is 200 to 207 code
   *
   * @return boolean
   */
  public function isSuccess()
  {
    $success = $this->checkForSuccess();  
    if ($success) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * isFailure()
   * An alias to the opposite of isSuccess()
   *
   * @return boolean
   */
  public function isFailure()
  {
    return !$this->isSuccess();
  }

  /**
   * checkForSuccess()
   * Checks if the request is a success or not (200 to 207 code)
   *
   * @return boolean
   */
  public function checkForSuccess()
  {
    if (!$this->_success) {
      $statusCode = $this->getCode();
      if ($statusCode >= 200 && $statusCode <= 207) {
        $this->_success = true;
      } else {
        $this->_success = false;
      }
    }

    return $this->_success;
  }
}
