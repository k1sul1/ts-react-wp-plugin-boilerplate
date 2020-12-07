<?php

namespace NS;

class DbIo extends Module {
  private $collate;

  public function __construct(Plugin $plugin) {
    parent::__construct($plugin);

    $this->core->collate = !empty(\DB_COLLATE) ? \DB_COLLATE : 'utf8mb4_unicode_ci';
  }

  public function createSomeTable($force = false) {
    [$db, $prefix] = db();
    $tableName = 'sometable';
    $collate = $this->core->collate;

    if ($force) {
      if (!$db->query("DROP TABLE IF EXISTS `$tableName`;")) {
        throw new Error($db->last_error);
      }
    }

    /**
     * Rows are automatically deleted when a form is deleted
     */
    if (
        !$db->query("
      CREATE TABLE `$tableName` (
        `id` bigint(20) NOT NULL AUTO_INCREMENT,
        `formId` bigint(20) UNSIGNED NOT NULL COMMENT 'Joins with ID in wp_posts',
        `fields` LONGTEXT NOT NULL COMMENT 'Fields in JSON form',
        `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `modified` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`formId`) REFERENCES {$prefix}posts(ID) ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE={$collate};
    ")
    ) {
      throw new Error($db->last_error);
    }

    return true;
  }
}
