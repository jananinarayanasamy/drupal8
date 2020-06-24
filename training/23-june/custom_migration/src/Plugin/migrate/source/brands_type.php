<?php

namespace Drupal\custom_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for the brands_type.
 *
 * @MigrateSource(
 *   id = "brands_type"
 * )
 */
class brands_type extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('brands_type', 'g')
      ->fields('g', ['id', 'brand_id', 'name']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('Type Id'),
      'brand_id' => $this->t('Brand Id'),
      'name' => $this->t('Type name'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'id' => [
        'type' => 'integer',
        'alias' => 'g',
      ],
    ];
  }
}