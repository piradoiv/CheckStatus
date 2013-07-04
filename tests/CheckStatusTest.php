<?php

class CheckStatusTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    $this->checker = new CheckStatus\CheckStatus();
    $this->url = 'http://localhost/';
    $this->response = $this->checker->fetchUrl($this->url);
  }

  public function testComposerIsLoaded()
  {
    $curl = new Curl();
    $this->assertInstanceOf('Curl', $curl, "Try running composer install");
  }

  public function testCanFetchUrl()
  {
    $response = $this->response;

    $this->assertNotNull($response);
    $this->assertInstanceOf('CheckStatus\Status', $response);
    $this->assertNotNull($response->getCode());
    $this->assertEquals(200, $response->getCode());
  }

  public function testResponseTime()
  {
    $response = $this->response;
    $responseTime = $response->getResponseTime();

    $this->assertNotNull($responseTime);
    $this->assertGreaterThan(0, $responseTime);
  }
}
