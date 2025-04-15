<?php
ob_start();



/**
 * Set env variables and enable error reporting in local environment
 */
require_once(__DIR__ . "/lib/env.php"); // sets global env variables (database configuration)
require_once(__DIR__ . "/lib/error_reporting.php"); // enables error reporting locally

/**
 * Start user session
 */
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Require routing library
 *  allows handling request for different URL routes, i.e. /users, /products, etc.
 */
require_once(__DIR__ . "/lib/Route.php");

/**
 * Require routes
 *  Defines the routes that our application will ned
 */
require_once(__DIR__ . "/routes/index.php");
require_once(__DIR__ . "/routes/user.php");
require_once(__DIR__ . "/routes/registrationRoute.php");
require_once(__DIR__ . "/routes/verify-email.php");
require_once(__DIR__ . "/routes/history.php");
require_once(__DIR__ . "/routes/registrationRoute.php");
require_once(__DIR__ . "/routes/magic.php");
require_once(__DIR__ . "/routes/login.php");
require_once(__DIR__ . "/routes/admin.php");
require_once(__DIR__ . "/routes/shoppingCart.php");
require_once __DIR__ . '/routes/jazz.php';
require_once __DIR__ . '/routes/orderRoute.php';
require_once(__DIR__ . "/routes/yummy.php");

require_once(__DIR__ . "/routes/dance.php");
require_once __DIR__ . '/routes/payment.php';


// Start the router, enabling handling requests
Route::run();
ob_end_flush();