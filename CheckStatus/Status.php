<?php

namespace CheckStatus;

class Status
{
  private $_response;
  private $_code;
  private $_responseTime;

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

  public function setResponseTime($time) {
    $this->_responseTime = $time;
  }
}
