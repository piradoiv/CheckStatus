<?php

class CheckStatusTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    $this->url = 'http://localhost/';
  }

  public function testComposerIsLoaded()
  {
    $curl = new Curl();
    $this->assertInstanceOf('Curl', $curl, "Try running composer install");
  }

  public function testCanFetchUrl()
  {
    $checker = new CheckStatus\CheckStatus();
    $response = $checker->fetchUrl('http://localhost/');

    $this->assertNotNull($response);
    $this->assertInstanceOf('CheckStatus\Status', $response);
    $this->assertNotNull($response->getCode());
    $this->assertEquals(200, $response->getCode());
  }
}
