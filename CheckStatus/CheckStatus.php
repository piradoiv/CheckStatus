<?php

namespace CheckStatus;

class CheckStatus
{
  public function fetchUrl($url = null)
  {
    $initTime = microtime(true);
    $curl = new \Curl();
    $response = $curl->get($url);
    $status = new Status($response);
    $status->setResponseTime(microtime(true) - $initTime);

    return $status;
  }
}
