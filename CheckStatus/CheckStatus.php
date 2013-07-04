<?php

namespace CheckStatus;

class CheckStatus
{
  public function fetchUrl($url = null)
  {
    $curl = new \Curl();
    $initTime = microtime(true);
    $response = $curl->get($url);
    $responseTime = microtime(true) - $initTime; 
    $status = new Status($response);
    $status->setResponseTime($responseTime);

    return $status;
  }
}
