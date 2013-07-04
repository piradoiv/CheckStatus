<?php

class CheckStatusTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    $this->checker = new CheckStatus\CheckStatus();
    $this->url = 'http://www.piradoiv.com/';
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

  public function testPrepareUrl()
  {
    $this->assertEquals('http://example.com', $this->checker->prepareUrl('example.com'));
    $this->assertEquals('http://gphasdgoaief.com', $this->checker->prepareUrl('gphasdgoaief.com'));
  }

  public function testInvalidUrls()
  {
    $this->assertFalse($this->checker->isValidUrl('gphasdgoaief'));
    $this->assertTrue($this->checker->isValidUrl('gphasdgoaief.com'));
    $this->assertTrue($this->checker->isValidUrl('https://www.google.com/'));
    $this->assertTrue($this->checker->isValidUrl('http://www.piradoiv.com/'));
  }

  public function testPreventFetchInvalidUrls()
  {
    $this->assertFalse($this->checker->fetchUrl('gapohwiawfeih'));
  }

  public function testResponseTime()
  {
    $response = $this->response;
    $responseTime = $response->getResponseTime();

    $this->assertNotNull($responseTime);
    $this->assertGreaterThan(0, $responseTime);
  }

  public function testSuccess()
  {
    $response = $this->response;
    $isSuccess = $response->isSuccess();

    $this->assertTrue($isSuccess);
  }

  public function testFailure()
  {
    $response = $this->response;
    $isFailure = $response->isFailure();

    $this->assertFalse($isFailure);
  }
}
