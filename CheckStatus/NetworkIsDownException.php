<?php

namespace CheckStatus;

class NetworkIsDownException extends \Exception
{
  protected $message = 'Network is down';
}
