<?php

use PHPUnit\Framework\TestCase;

// Define constants.
define('DATAPLANS_TOKEN', '');
define('DATAPLANS_API_MODE', 'sandbox');
define('DATAPLANS_API_VERSION', 1);

// Include necessary file.
require_once dirname(__FILE__) . '/../../lib/DataPlans.php';
// if (version_compare(phpversion(), '5.6.0') >= 0 && file_exists(dirname(__FILE__) . '/../../vendor/autoload.php')) {
//     require_once dirname(__FILE__) . '/../../vendor/autoload.php';
// } else {
//     require_once dirname(__FILE__) . '/../../lib/DataPlans.php';
// }

abstract class TestConfig extends TestCase
{
}
