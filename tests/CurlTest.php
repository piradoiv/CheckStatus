<?php

class CurlTest extends PHPUnit_Framework_TestCase
{
  private $curl;

  public function setUp()
  {
    $this->curl = new CheckStatus\Curl;
  }

  public function testClassExists()
  {
    $this->assertInstanceOf('CheckStatus\Curl', $this->curl);
  }

  public function testCanFetchUrl()
  {

  }
}
