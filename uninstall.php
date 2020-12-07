<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
  die;
}

require_once 'index.php';

myEmptyPlugin()->onUninstall();
