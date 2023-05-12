<?php

namespace Drupal\funfields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the RGB Color formatter.
 *
 * @FieldFormatter(
 *   id = "rgb_formatter",
 *   label = @Translation("RGB Formatter"),
 *   field_types = {
 *     "rgb"
 *   }
 * )
 */
class ColorFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    // Loop over the items as the field may have multiple values.
    foreach ($items as $delta => $item) {

      $element = [
        '#markup' => $item->red
      ];

      // Render each element as markup.
      // $element[$delta] = [
      //   '#theme' => 'meganame',
      //   '#prefix_name' => !empty($item->prefix_other) ? $item->prefix_other : $item->prefix,
      //   '#first' => $item->first,
      //   '#middle' => $item->middle,
      //   '#last' => $item->last,
      //   '#suffix_name' => $item->suffix,
      //   '#nickname' => $item->nickname,
      // ];
    }

    return $element;
  }

}
