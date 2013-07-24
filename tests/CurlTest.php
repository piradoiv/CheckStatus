<?php

class CurlTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
  }

  public function testClassExists()
  {
    $curl = new CheckStatus\Curl();
    $this->assertInstanceOf('CheckStatus\Curl', $curl);
  }
}
