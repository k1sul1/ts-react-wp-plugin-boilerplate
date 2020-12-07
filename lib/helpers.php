<?php

namespace NS;

function isDebug() {
  return defined('WP_DEBUG') && WP_DEBUG == true; // Loose comparison to support 1, 'yes' etc
}

function isRest() {
  return defined('REST_REQUEST');
}

function log($anything) {
  error_log('myEmptyPlugin: ' . print_r($anything, true));
}

function minifyHtml(string $html) {
  return str_replace(array("\n", "\r"), ' ', $html);
}

function db() {
  global $wpdb;

  return [
    $wpdb,
    $wpdb->prefix,
  ];
}

function currentUrl() {
  $protocol = (isset($_SERVER['HTTPS']) ? "https" : "http");

  return "$protocol://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

function uuid() {
  $data = \random_bytes(16);
  assert(strlen($data) == 16);

  $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
  $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

  return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
