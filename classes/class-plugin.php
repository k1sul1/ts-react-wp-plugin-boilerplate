<?php

namespace NS;

class Plugin {
  // Always loaded
  public $io;
  public $frontend;

  // Loaded conditionally
  public $restApi;
  public $adminInterface;


  // Passed in the constructor
  public $version;
  public $url;
  public $dirname;

  public function __construct($data = []) {
    $this->version = $data['version'] ?? null;
    $this->url = $data['url'] ?? null;
    $this->dirname = $data['dirname'] ?? null;

    require_once 'entities/class-module.php';
    require_once 'entities/class-error.php';
  }

  public function initialize() {
    $this->loadModule('io');
    $this->loadModule('frontend');

    if (is_admin()) {
      $this->loadModule('admin-interface');
    }

    $this->initializeActions();
    $this->initializeFilters();
  }

  private function initializeActions() {
    add_action('rest_api_init', [$this, 'afterRestApiInit']);
    add_action('init', [$this, 'afterInit']);
  }

  private function initializeFilters() {

  }

  public function afterInit() {
    // load plugin textdomain etc
  }

  public function afterRestApiInit() {
    $this->loadModule('rest-api');
  }

  public function getLocalizeScriptData(array $additional = []) {
    $x = array_merge([
      'backendUrl' => rest_url('myEmptyPlugin/v2'),
      'requestHeaders' => (object) [
        'X-WP-Nonce' =>  wp_create_nonce('wp_rest'), // user auth
      ],

      'i18n' => [
        'loading' => __('Loading...', 'myemptyplugin'),
        'close' => __('Close', 'myemptyplugin'),
      ]
    ], $additional);

    return $x;
  }


  /**
   * Plugin activation hook. Must be a static method to work.
   */
  public static function onActivation() {
    isDebug() && log('Activated');

    flush_rewrite_rules();
  }

  /**
   * Plugin deactivation hook. Must be a static method to work.
   */
  public static function onDeactivation() {
    isDebug() && log('Deactivated');

    flush_rewrite_rules();
  }

  /**
   * Plugin uninstall hook. Called by uninstall.php.
   * Unreliable, if plugin is uninstalled by removing the files, this will obviously not run. Should probably add a dedicated "remove data and deactivate" button instead if you need this.
   */
  public function onUninstall() {

  }

  /**
   * Modules must be named as class-kebab-case.php, and they must contain a class with the
   * same name in PascalCase: class KebabCase extends X {}.
   */
  private function loadModule(string $moduleName, ...$params) {
    $path = "modules/class-$moduleName.php";

    require_once $path;

    $className = str_replace('-', '', ucwords($moduleName, '_')); // Convert to PascalCase
    $instanceVariable = lcfirst($className);
    $namespacedClassName = "\\NS\\$className";

    $module = new $namespacedClassName($this, ...$params);
    $this->{$instanceVariable} = $module;
  }
}
