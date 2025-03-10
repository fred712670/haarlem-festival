<?php

/**
 * Set env variables and enable error reporting in local environment
 */
require_once(__DIR__ . "/lib/env.php"); // sets global env variables (database configuration)
require_once(__DIR__ . "/lib/error_reporting.php"); // enables error reporting locally

// Enable error display for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 * Start user session
 */
session_start();

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
require_once(__DIR__ . "/routes/magic.php");
require_once(__DIR__ . "/routes/admin.php");


echo "<!-- Total routes registered: " . count(Route::getAll()) . " -->";


// Start the router, enabling handling requests
Route::run();
