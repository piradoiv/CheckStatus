<?php

class NetworkTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    $this->network = new CheckStatus\Network(false);
    $this->network->testUrl = 'http://localhost/';
  }

  public function testLastCheck()
  {
    $net = &$this->network;
    $this->assertNull($net->lastCheck);

    $net->check();
    $this->assertNotNull($net->lastCheck);
  }

  public function testRecheckAfter()
  {
    $net = &$this->network;
    $net->check();
    $firstLastCheck = $net->lastCheck;
    $net->check();
    $secondLastCheck = $net->lastCheck;
    $net->lastCheck = 0;
    $net->check();
    $thirdLastCheck = $net->lastCheck;

    $this->assertEquals($firstLastCheck, $secondLastCheck);
    $this->assertNotEquals($firstLastCheck, $thirdLastCheck);
  }

  public function testAvailability()
  {
    $net = &$this->network;
    $net->testUrl = 'http://gahiowegaiwhoeg.com';
    $net->check();
    $this->assertFalse($net->available);

    $net->lastCheck = 0; // Forces to refresh the availability
    $net->testUrl = 'http://localhost/';
    $net->check();
    $this->assertTrue($net->available);
  }
}
