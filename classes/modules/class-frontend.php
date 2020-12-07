<?php

namespace NS;

class Frontend extends Module {
  public function __construct(Plugin $plugin) {
    parent::__construct($plugin);

    add_action('wp_enqueue_scripts', [$this, 'enqueueFrontendAssets'], 9);
  }

  public function enqueueFrontendAssets() {
    $version = isDebug() ? date('U') : $this->core->version;
    $data = $this->core->getLocalizeScriptData();
// var_dump($this->core->url . (isDebug() ? '/dist/frontend.js' : '/dist/frontend.min.js'));
    // die("WTF");

    wp_enqueue_script(
        'myEmptyPlugin-frontend',
        $this->core->url . (isDebug() ? '/dist/frontend.js' : '/dist/frontend.min.js'),
        ['react', 'react-dom'],
        $version,
        true
    );
    wp_enqueue_style('myEmptyPlugin-frontend', $this->core->url . (isDebug() ? '/dist/frontend.css' : '/dist/frontend.min.css'), [], $version);
    wp_localize_script('myEmptyPlugin-frontend', 'myEmptyPlugin', $data);
  }
}
