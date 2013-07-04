<?php

namespace CheckStatus;

class Status
{
  private $_response;
  private $_code;
  private $_responseTime;
  private $_success;

  public function __construct(\CurlResponse $response = null)
  {
    $this->_response = $response;
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
    return $this->_responseTime;
  }

  public function getSummary()
  {
    $summary = array(
      'success' => $this->isSuccess(),
      'failure' => $this->isFailure(),
      'responseTime' => $this->getResponseTime()
    );

    return $summary;
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
