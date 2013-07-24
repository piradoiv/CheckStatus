CheckStatus Library
===================
[![Build Status](https://travis-ci.org/piradoiv/CheckStatus.png?branch=master)](https://travis-ci.org/piradoiv/CheckStatus)

This micro library aims just to connect to a URL and return the status of the response, like the status code, response milliseconds and a few more details.

Install it via [Composer](http://getcomposer.org/)
-----------------------

On your composer.json…

```
{
  "require": {
    "checkstatus/checkstatus": "dev-master"
  }
}
```

Example of usage
----------------

```
<?php
// Load Composer's autoload
require './vendor/autoload.php';

// Prepare some settings
$checkStatus = new CheckStatus\CheckStatus;
$url = 'http://www.example.com/';

// Need to use a proxy?, you're covered
$checkStatus->setProxy('111.111.111.111:80');
$checkStatus->setProxyAuth('username:password');

// Fetch the data
$status = $checkStatus->fetchUrl($url);

// Milliseconds
echo $status->getResponseTime();

// Status code
echo $status->getCode();

// URL used to generate the report
echo $status->getUrl();

// When did we fetch the URL?
echo $status->getTimestamp();

// All together
$summary = $status->getSummary();
print_r($summary);
```

Any question?
-------------

Follow me ([@PiradoIV](http://twitter.com/PiradoIV)) at Twitter.

