# DataPlans PHP Client

![PHPUnit](https://github.com/thebusted/dataplans-php/workflows/PHPUnit/badge.svg)
![CircleCI](https://circleci.com/gh/thebusted/dataplans-php.svg?style=shield)

`dataplans-php` is a library designed specifically to connect with DataPlans API written in PHP. API document [here](https://app.dataplans.io/docs/v1#/)

Please pop onto our community forum or contact [support@dataplans.io](mailto:support@dataplans.io) if you have any question regarding this library and the functionality it provides.

## Requirements

* PHP v5.6 and above.
* Built-in [libcurl](http://php.net/manual/en/book.curl.php) support.

## Configuration

### • Config your public and secret keys

This API allows you to buy travel eSIM data plans in QR code format. Sign up and receive your api-key to test the API. (these can be found at the [DataPlans Dashboard](https://esims.dataplans.io/dashboard).).

Place the following code next to a line where DataPlans-PHP library is loaded.

```php
define('DATAPLANS_TOKEN', '***'); // Access token
define('DATAPLANS_API_MODE', 'sandbox'); // Allow sandbox or esim
define('DATAPLANS_API_VERSION', 1); // API version
```

_Reference: [https://app.dataplans.io/docs/v1#/](https://app.dataplans.io/docs/v1#/)._

ー

## Development and Testing

To run an automated test suite, make sure you already have a [PHPUnit](https://phpunit.de) in your local machine.
Then run the PHPUnit:

```bash
phpunit tests
```

## License

DataPlans-PHP is open-sourced software released under the [Apache-2.0 License](https://www.apache.org/licenses/LICENSE-2.0.html).
