<?php

namespace CheckStatus;

class CheckStatus
{
  public function fetchUrl($url = null)
  {
    $curl = new \Curl();
    $response = $curl->get($url);
    $status = new Status($response);

    return $status;
  }
}
