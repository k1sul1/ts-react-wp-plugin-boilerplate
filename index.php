<?php
/**
 * Plugin name: Empty plugin
 * Plugin URI:
 * Description:
 * Version: 1
 * Author:
 * Author URI:
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl.html
 * Text Domain: myemptyplugin
 *
 */

require_once 'lib/helpers.php';

// For convenience, this file declares a function and executes side effects. We don't need a babysitter here.
// phpcs:disable

/**
 * Get the instance. Always use this method to
 * interact with the instance, do not create your own instance.
 */
function myEmptyPlugin(...$params) {
  static $instance;

  if (!$instance) {
    // require_once apply_filters('prefixPluginClassLocation', 'classes/class-plugin.php');
    require_once 'classes/class-plugin.php';

    $instance = new NS\Plugin(...$params);
  }

  return $instance;
}


[$version] = get_file_data(__FILE__, ['Version']);

$plugin = myEmptyPlugin([
  'dirname' => dirname(plugin_basename(__FILE__)),
  'url' => plugins_url('', __FILE__),
  'version' => $version,
]);

// add_action('plugins_loaded', function() use ($plugin) {
$plugin->initialize();
// });

// These will not work inside init, they must be top level: https://developer.wordpress.org/reference/functions/register_activation_hook/
register_activation_hook(__FILE__, [$plugin, 'onActivation']);
register_deactivation_hook(__FILE__, [$plugin, 'onDeactivation']);
