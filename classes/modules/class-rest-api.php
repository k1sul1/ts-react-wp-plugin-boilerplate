<?php

namespace NS;

class RestApi extends Module {
  public $namespace = 'myEmptyPlugin/v2';

  public function __construct(Plugin $plugin) {
    parent::__construct($plugin);

    $this->registerEndpoints();
  }

  public function registerEndpoints() {
    $this->registerSomeEndpoints();

    // $this->core->registerSubmitEndpoint();
    // $this->core->registerRenderEndpoint();
    // $this->core->registerFormEndpoints();
  }

  public function registerSomeEndpoints() {
    $endpoint = 'xy';

    register_rest_route($this->namespace, $endpoint, [
      'callback' => [$this, $endpoint],
      'methods' => ['GET'],
      // 'permission_callback' => '\NS\currentUserIsAllowedToUse',
      'permission_callback' => '__return_true',
    ]);

    $endpoint = 'xyz';

    register_rest_route($this->namespace, $endpoint, [
      'callback' => [$this, $endpoint],
      'methods' => ['GET'],
      // 'permission_callback' => '\NS\currentUserIsAllowedToUse',
      'permission_callback' => '__return_true',
    ]);

  }


  public function xy($request) {
    try {
      $response = $this->createResponse(['something' => true], __FUNCTION__);

      return $response;
    } catch (Error $e) {
      isDebug() && log($e->getMessage());

      return $this->core->createError($e);
    }
  }

  // Throw errors to fail gracefully.
  public function xyz($request) {
    try {
      throw new Error('This will not do.', ['git gud' => 'scrub']);
    } catch (Error $e) {
      isDebug() && log($e->getMessage());

      return $this->createError($e);
    }
  }

  public function createError(Error $e) {
    return new \WP_REST_Response([
      'error' => $e->getMessage(),
      'data' => $e->getData(),
      'trace' => isDebug() ? $e->getTrace() : null,
      'kind' => 'apiError',
    ], 500);
  }

  /**
   * Always use this instead of \WP_REST_Response directly.
   *
   * @param $kind is used for typing responses.
   *
   * Unless you have a good reason, the only valid value to it is __FUNCTION__, but magic constants can't be used as defaults.
   */
  public function createResponse($data, string $kind) {
    return new \WP_REST_Response([
      'kind' => $kind,
      'data' => $data
    ]);
  }
}
