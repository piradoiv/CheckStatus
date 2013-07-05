<?php

namespace CheckStatus;

class CheckStatus
{
  public function fetchUrl($url = null)
  {
    if (!$this->isValidUrl($url)) {
      return false;
    }

    $curl = new \Curl();
    $initTime = microtime(true);
    
    try {
      $response = $curl->get($url);
    } catch(\CurlException $e) {
      $response = false;
    }
    
    $responseTime = microtime(true) - $initTime; 
    $status = new Status($response);
    $status->setResponseTime($responseTime);
    $status->setUrl($url);

    return $status;
  }

  public function isValidUrl($url = null)
  {
    if (!$url) {
      return false;
    }

    $url = $this->prepareUrl($url);
    $parsedUrl = parse_url($url);

    if (!isset($parsedUrl['host'])) {
      return false;
    }

    if (!preg_match("/\./", $parsedUrl['host'])) {
      return false;
    }
  
    return true;
  }

  public static function prepareUrl($url = null)
  {
    $pattern = "/^http(s)?:\/\//";

    if (!preg_match($pattern, $url)) {
      $url = "http://{$url}";
    }

    return $url;
  }
}
