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
    $curl = &$this->curl;
    $response = $curl->get('http://www.piradoiv.com/');
    $this->assertInternalType('array', $response);
  }

  public function testCanSetAProxy()
  {
    $proxy = '111.95.243.36:80';
    $curl = &$this->curl;
    $curl->setProxy($proxy);
    $this->assertEquals($curl->proxy, $proxy);
  }

  public function testCanSetAuthentication()
  {
    $auth = 'username:password';
    $curl = &$this->curl;
    $response = $curl->setAuth($auth);
    $this->assertTrue($response);
  }
}
