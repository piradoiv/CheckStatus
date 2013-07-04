<?php

class CheckStatusTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
  }

  public function testComposerIsLoaded()
  {
    $curl = new Curl();
    $this->assertInstanceOf('Curl', $curl, "Try running composer install");
  }
}
