<?php

class CheckStatusTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    $this->checker = new CheckStatus\CheckStatus();
    $this->checker->network->testUrl = 'http://www.piradoiv.com/';
    $this->url = 'http://www.piradoiv.com/';
    $this->response = $this->checker->fetchUrl($this->url);
  }

  public function testComposerIsLoaded()
  {
    $curl = new CheckStatus\Curl;
    $this->assertInstanceOf('CheckStatus\Curl', $curl, "Try running composer install");
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

  public function testSummary()
  {
    $response = $this->response;
    $summary = $response->getSummary();

    $this->assertTrue(is_array($summary));
    $this->assertNotEmpty($summary);
    $this->assertTrue(isset($summary['success']));
    $this->assertTrue(isset($summary['failure']));
    $this->assertTrue(isset($summary['responseTime']));
  }

  public function testNotFoundUrlsShouldReturnEmptySummary()
  {
    $response = $this->checker->fetchUrl('http://www.piradoiv.es/');
    $summary = $response->getSummary();

    $this->assertTrue(isset($summary['failure']));
  }

  public function testSummaryHasUrl()
  {
    $response = $this->response;
    $summary = $response->getSummary();

    $this->assertNotNull($response->getUrl());
    $this->assertNotNull($summary['url']);
  }

  public function testTimestamp()
  {
    $response = $this->response;
    $summary  = $response->getSummary();

    $this->assertNotNull($response->getTimestamp());
    $this->assertNotNull($summary['timestamp']);
  }

  /**
   * @expectedException CheckStatus\NetworkIsDownException
   */
  public function testExceptionOnDownNetwork()
  {
    $checker = &$this->checker;
    $checker->network->available = false;
    $checker->fetchUrl('http://www.example.com/');
  }

  /**
   * @expectedException CheckStatus\NetworkIsDownException
   */
  public function testThrowsNetworkIsDownWhenProxyFails()
  {
    $checker = &$this->checker;
    $checker->redirections = 3;
    $checker->proxy = '241.111.111.111:1234';
    $checker->fetchUrl('http://www.piradoiv.com/');
  }
}
