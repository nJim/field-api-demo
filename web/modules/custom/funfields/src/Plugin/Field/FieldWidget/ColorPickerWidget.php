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

    // Load the default values for this field.
    $red = $items[$delta]->red ?? '00';
    $green = $items[$delta]->green ?? '00';
    $blue = $items[$delta]->blue ?? '00';

    $element['picker'] = [
      '#type' => 'color',
      '#default_value' => $this->rgb2hex($red, $green, $blue),
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
      $color = $this->hex2rgb($item['picker']);
      $item['red'] = $color['red'];
      $item['green'] = $color['green'];
      $item['blue']= $color['blue'];
    }
    return $values;
  }

  /**
   * Convert rgb to hex.
   *
   * @param integer $red
   *   An integer value from 0 to 255 for the red channel.
   * @param integer $green
   *   An integer value from 0 to 255 for the green channel.
   * @param integer $blue
   *   An integer value from 0 to 255 for the blue channel.
   * @return string
   *   A hex color with the preceding hash sign.
   */
  protected function rgb2hex(int $red, int $green, int $blue): string {
    return sprintf("#%02x%02x%02x", $red, $green, $blue);
  }

  /**
   * Convert hex to rgb component values in an array.
   *
   * @param string $hex
   *   A hexidecimal color with a preceding hash sign.
   * @return array
   *   An array of component colors in RBG channels.
   */
  protected function hex2rgb(string $hex): array {
    $color = ltrim($hex, '#');
    return [
      'red' => hexdec(substr($color, 0, 2)),
      'green' => hexdec(substr($color, 2, 2)),
      'blue' => hexdec(substr($color, 4, 2)),
    ];
  }

}
