<?php

namespace CheckStatus;

class Status
{
  private $_response;
  private $_code;

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
}
