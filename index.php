<?php
/**
 * Root Index - Application Entry Point
 * This file serves as the application entry point when the document root is the project root
 */

// Parse the REQUEST_URI to separate path from query string
$request_uri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($request_uri, PHP_URL_PATH) ?? '/';
$query = parse_url($request_uri, PHP_URL_QUERY) ?? '';

// Set SCRIPT_NAME to point to public/index.php (without query string)
$_SERVER['SCRIPT_NAME'] = '/public/index.php';
$_SERVER['PHP_SELF'] = '/public/index.php' . $path;
$_SERVER['REQUEST_URI'] = $path . ($query ? '?' . $query : '');

// Include the public index file
require_once __DIR__ . '/public/index.php';
