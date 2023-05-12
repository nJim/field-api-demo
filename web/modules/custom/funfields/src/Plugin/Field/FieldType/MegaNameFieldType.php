<?php

namespace Drupal\funfields\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Provides a field type of Mega Name.
 *
 * This field type combines many parts of a person's name into a single Drupal
 * field type. While this example is fictitious, it is a common use case to
 * group multiple related or dependent values into a single field. Examples
 * include the core link field which contains a title and URL; or the contrib
 * address field which includes a rigid set of values.
 *
 * @FieldType(
 *   id = "meganame",
 *   label = @Translation("Mega Name Field"),
 *   default_formatter = "meganame_formatter",
 *   default_widget = "meganame_widget",
 * )
 */
class MegaNameFieldType extends FieldItemBase {

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
        'prefix' => [
          'type' => 'text',
          'size' => 'tiny',
          'not null' => FALSE,
        ],
        'first' => [
          'type' => 'text',
          'size' => 'normal',
          'not null' => FALSE,
        ],
        'middle' => [
          'type' => 'text',
          'size' => 'normal',
          'not null' => FALSE,
        ],
        'last' => [
          'type' => 'text',
          'size' => 'normal',
          'not null' => TRUE,
        ],
        'suffix' => [
          'type' => 'text',
          'size' => 'tiny',
          'not null' => FALSE,
        ],
        'nickname' => [
          'type' => 'text',
          'size' => 'normal',
          'not null' => FALSE,
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

    $properties['prefix'] = DataDefinition::create('string')
      ->setLabel(t('Prefix'))
      ->setDescription(t('A professional title or salutation.'));
    $properties['first'] = DataDefinition::create('string')
      ->setLabel(t('First Name'))
      ->setDescription(t('A first name or given name.'));
    $properties['middle'] = DataDefinition::create('string')
      ->setLabel(t('Middle Name'))
      ->setDescription(t('An alternative name.'));
    $properties['last'] = DataDefinition::create('string')
      ->setLabel(t('Last Name'))
      ->setDescription(t('A family name or surname.'))
      ->setRequired(TRUE);
    $properties['suffix'] = DataDefinition::create('string')
      ->setLabel(t('Suffix'))
      ->setDescription(t('A generational title or professional suffix.'));
    $properties['nickname'] = DataDefinition::create('string')
      ->setLabel(t('Nick Name'))
      ->setDescription(t('The text with the text format applied.'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('suffix')->getValue();
    return $value === NULL || $value === '';
  }

}
