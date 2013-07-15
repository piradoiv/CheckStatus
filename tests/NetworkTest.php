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

    $this->assertEquals($firstLastCheck, $secondLastCheck);
  }

  public function testAvailability()
  {
    $net = &$this->network;
    $net->testUrl = 'http://gahiowegaiwhoeg.com';
    $net->check();
    $this->assertFalse($net->available);

    $net->lastCheck = 0; // Forces to refresh the availability
    $net->testUrl = 'http://www.google.com/';
    $net->check();
    $this->assertTrue($net->available);
  }
}
