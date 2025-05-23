<?php

/**
 * Template Name: logout
 */


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = array();
session_unset();
session_destroy();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

header("Location: " . home_url('/login'));
exit();
