<?php

namespace Drupal\funfields\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a widget for the RGB Color field that provides random color options.
 *
 * @FieldWidget(
 *   id = "rgb_picker_widget",
 *   label = @Translation("Color Picker"),
 *   field_types = {
 *     "rgb"
 *   }
 * )
 */
class ColorPickerWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    // A field may have multiple values if cardinality is not set to 1.
    /** @var \Drupal\link\LinkItemInterface $item */
    $item = $items[$delta];

    $red = $items[$delta]->red ?? '00';
    $green = $items[$delta]->green ?? '00';
    $blue = $items[$delta]->blue ?? '00';

    $element['picker'] = [
      '#type' => 'color',
      '#default_value' => sprintf("#%02x%02x%02x", $red, $green, $blue),
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    // Loop through the values as this could be a multivalue field.
    foreach ($values as &$item) {
      // The widget form uses the native 'color' element which stores colors as
      // the hex value. We need to get this into an RGB form for storage.
      $color = $item['picker'];
      $hex = ltrim($color, '#');
      $length   = strlen($hex);
      $item['red'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
      $item['green'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
      $item['blue']= hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
    }
    return $values;
  }

}
