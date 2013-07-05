<?php

namespace CheckStatus;

class Status
{
  private $_response;
  private $_code;
  private $_responseTime;
  private $_success;
  private $_url;

  public function __construct($response = null)
  {
    $this->_response = $response;

    return $this->getSummary();
  }

  public function getCode()
  {
    if (!$this->_code) {
      $this->_code = $this->_response->headers['Status-Code'];
    }

    return $this->_code;
  }

  public function getResponseTime()
  {
    if (gettype($this->_responseTime) == 'double') {
      $this->_responseTime *= 1000;
      settype($this->_responseTime, 'integer');
    }

    return $this->_responseTime;
  }

  public function getSummary()
  {
    if ($this->_response instanceof \CurlResponse) {
      $summary = array(
        'success' => $this->isSuccess(),
        'failure' => $this->isFailure(),
        'responseTime' => $this->getResponseTime(),
        'url' => $this->getUrl()
      );

    } else {
      $summary = array(
        'success' => false,
        'failure' => true,
        'responseTime' => -1,
        'url' => $this->getUrl()
      );
    }
    

    return $summary;
  }

  public function getUrl()
  {
    return $this->_url;
  }

  public function setUrl($url = null)
  {
    if (!$url) {
      return false;
    }

    $this->_url = $url;

    return true;
  }

  public function setResponseTime($time)
  {
    $this->_responseTime = $time;
  }

  public function isSuccess()
  {
    $success = $this->checkForSuccess();  
    if ($success) {
      return true;
    } else {
      return false;
    }
  }

  public function isFailure()
  {
    return !$this->isSuccess();
  }

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
