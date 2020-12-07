<?php

namespace NS;

/**
 * All database and filesystem operations live here. IO operations are expensive, try to avoid making any unnecessary calls.
 */
class Io extends Module {
  // Subclasses can be used for splitting operations into spesific categories:
  // public $db;

  public function __construct(Plugin $plugin) {
    parent::__construct($plugin);

    // Init subclass
    // require_once __DIR__ . '/io/class-db-io.php';
    // $this->core->db = new DbIo($plugin);
  }

  /**
   * Generic get_option wrapper, prefixes for you.
   */
  public function getOption(string $name, $defaultData = null) {
    return get_option("NS$name", $defaultData);
  }

    /**
   * Generic set_option wrapper, prefixes for you.
   */
  public function setOption(string $name, $data = null) {
    return update_option("NS$name", $data);
  }

  /**
   * $wpdb spits out error messages that break things as
   * API responses if WP_DEBUG is on.
   *
   * If this method returns true, the errors were on previously.
   * Remember to set them back on with showDbErrors().
   */
  public function hideDbErrors() {
    [$wpdb] = db();

    return $wpdb->hide_errors();
  }

  public function showDbErrors() {
    [$wpdb] = db();

    return $wpdb->show_errors();
  }
}
