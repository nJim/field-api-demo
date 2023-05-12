<?php

namespace Drupal\funfields\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Provides a field type for storing an RGB color value
 *
 * This field combines three separate but related values to form an RGB color.
 * These values do not have much meaning on their own, so it makes sense to
 * group these into a single field definition. I hope this example can teach
 * Drupal developers how to create custom fields. However, there are better and
 * more complete modules for working with color -- so I would use an existing
 * project before adopting this RGB field.
 *
 * @FieldType(
 *   id = "rgb",
 *   label = @Translation("RGB Color Field"),
 *   default_formatter = "rgb_formatter",
 *   default_widget = "rgb_widget",
 * )
 */
class ColorFieldType extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    // Each value is stored in a separate column in the database. This schema is
    // applied to all new instances of this field for a given entity. It can be
    // difficult to change the schema once it contains production data, so we
    // are careful to pick sizes and limitations that are future-proof.
    // See data type sizes: https://www.drupal.org/node/159605
    return [
      'columns' => [
        'red' => [
          'type' => 'int',
          'size' => 'small',
          'not null' => TRUE,
        ],
        'green' => [
          'type' => 'int',
          'size' => 'small',
          'not null' => TRUE,
        ],
        'blue' => [
          'type' => 'int',
          'size' => 'small',
          'not null' => TRUE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Unlike many other languages, PHP is a very loosely typed language. It
    // doesn’t have a clear definition of the different types it deals with.
    // Drupal provides some much needed structure through the Typed Data API.
    // https://www.drupal.org/docs/drupal-apis/typed-data-api/data-definitions
    $properties = [];

    $properties['red'] = DataDefinition::create('integer')
      ->setLabel('Red')
      ->addConstraint('Range', ['min' => 0, 'max' => 255])
      ->setRequired(TRUE);
    $properties['green'] = DataDefinition::create('integer')
      ->setLabel('Green')
      ->addConstraint('Range', ['min' => 0, 'max' => 255])
      ->setRequired(TRUE);
      $properties['blue'] = DataDefinition::create('integer')
      ->setLabel('Blue')
      ->addConstraint('Range', ['min' => 0, 'max' => 255])
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $red = $this->get('red')->getValue();
    $green = $this->get('green')->getValue();
    $blue = $this->get('blue')->getValue();
    return $red === NULL || $red === '' || $green === NULL || $green === '' || $blue === NULL || $blue === '';
  }

}
