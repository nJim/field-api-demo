<?php

namespace Drupal\funfields\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a default widget for the RGB Color field.
 *
 * @FieldWidget(
 *   id = "rgb_default_widget",
 *   label = @Translation("RGB Value Fields"),
 *   field_types = {
 *     "rgb"
 *   }
 * )
 */
class ColorDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    // A field may have multiple values if cardinality is not set to 1.
    /** @var \Drupal\link\LinkItemInterface $item */
    $item = $items[$delta];

    // Attach the colorpicker library.
    $element['#attached']['library'][] = 'funfields/color-default';

    // Field widgets can take many different forms. Like the example below, they
    // can be simple implementations with the Drupals Forms API; or they can be
    // complex embedded applications. The key is that the value for each column
    // in the FieldType must be set as a named value on the returned element.
    $element['red'] = [
      '#type' => 'number',
      '#title' => $this->t('Red'),
      '#size' => '10',
      '#min' => 0,
      '#max' => 255,
      '#default_value' => $items[$delta]->red ?? NULL,
    ];
    $element['green'] = [
      '#type' => 'number',
      '#title' => $this->t('Green'),
      '#size' => '10',
      '#min' => 0,
      '#max' => 255,
      '#default_value' => $items[$delta]->green ?? NULL,
    ];
    $element['blue'] = [
      '#type' => 'number',
      '#title' => $this->t('Blue'),
      '#size' => '10',
      '#min' => 0,
      '#max' => 255,
      '#default_value' => $items[$delta]->blue ?? NULL,
    ];
    return $element;
  }

}
