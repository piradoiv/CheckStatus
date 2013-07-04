<?php

namespace CheckStatus;

class CheckStatus
{
  public function fetchUrl($url = null)
  {
    $initTime = microtime();
    $curl = new \Curl();
    $response = $curl->get($url);
    $status = new Status($response);
    $status->setResponseTime(microtime() - $initTime);

    return $status;
  }
}
