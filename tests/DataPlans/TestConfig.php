<?php

use PHPUnit\Framework\TestCase;

// Define constants.
define('DATAPLANS_TOKEN', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzaWQiOiJhNTRmNTdlOS1iODA5LTQyZGQtOWIxOC1mNTNjZTg1MTIzNDMiLCJpYXQiOjE1OTQ4NzM4NzAsImV4cCI6MjQ1ODc4NzQ3MH0.Jp-UTikHqMdntbYGStqpXg_sKAEdFurIu1RTzcXEZE8');
define('DATAPLANS_API_MODE', 'sandbox');
define('DATAPLANS_API_VERSION', 1);

// Include necessary file.
if (version_compare(phpversion(), '5.6.0') >= 0 && file_exists(dirname(__FILE__) . '/../../vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/../../vendor/autoload.php';
} else {
    require_once dirname(__FILE__) . '/../../lib/DataPlans.php';
}

abstract class TestConfig extends TestCase
{
}
