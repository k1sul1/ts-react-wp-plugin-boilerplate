<?php

namespace NS;

/**
 * Use this class to define shared methods. Each module contains the main plugin class instance for easy access.
 * If you add your modules as class properties to the main class, you can access pretty much everything from anywhere.
 */
abstract class Module {
  public $core;

  public function __construct(Plugin $plugin, ...$params) {
    $this->injectCore($plugin);
  }

  private function injectCore(Plugin $plugin) {
    $this->core = $plugin;
  }
}
