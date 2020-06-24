<?php
namespace Drupal\custom_migration\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for the brands.
 *
 * @MigrateSource(
 *   id = "brands"
 * )
 */
class brands extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('brands', 'd')	
      ->fields('d', ['id', 'name', 'description']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('Brand ID'),
      'name' => $this->t('Brand Name'),
      'description' => $this->t('Brand Description'),
      'brands_type' => $this->t('Brand Types'),
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
        'alias' => 'd',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $btype = $this->select('brands_type', 'g')
      ->fields('g', ['id'])
      ->condition('brand_id', $row->getSourceProperty('id'))
      ->execute()
      ->fetchCol();
    $row->setSourceProperty('brands_type', $btype);
    return parent::prepareRow($row);
  }
}