<?php

namespace NS;

class AdminInterface extends Module {
  public function __construct(Plugin $plugin) {
    parent::__construct($plugin);

    add_action('admin_init', [$this, 'onAdminInit']);
    add_action('admin_footer', [$this, 'enqueueAdminAssets'], 9);
  }

   public function onAdminInit() {
    // Nag, show notices, etc.
  }

  public function enqueueAdminAssets() {
    $version = isDebug() ? date('U') : $this->core->version;

    wp_enqueue_script('myEmptyPlugin-admin', $this->core->url . ( isDebug() ? '/dist/admin.js' : '/dist/admin.min.js'), ['react', 'react-dom'], $version, true);
    wp_enqueue_style('myEmptyPlugin-admincss', $this->core->url . (isDebug() ? '/dist/admin.css' : '/dist/admin.min.css'), [], $version);

    wp_localize_script('myEmptyPlugin-admin', 'myEmptyPlugin', $this->core->getLocalizeScriptData([
      'post' => $GLOBALS['post'] ?? null,
      'adminUrl' => admin_url(),
    ]));
  }
}
