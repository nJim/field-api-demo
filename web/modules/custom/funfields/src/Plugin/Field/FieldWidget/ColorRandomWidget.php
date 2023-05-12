<?php

namespace Drupal\funfields\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a widget for the RGB Color field that provides random color options.
 *
 * @FieldWidget(
 *   id = "rgb_random_widget",
 *   label = @Translation("Random Color Generator"),
 *   field_types = {
 *     "rgb"
 *   }
 * )
 */
class ColorRandomWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    // A field may have multiple values if cardinality is not set to 1.
    /** @var \Drupal\link\LinkItemInterface $item */
    $item = $items[$delta];

    // Attach the colorpicker library.
    $element['#attached']['library'][] = 'funfields/color-picker';

    $element['picker'] = [
      '#markup' => '<div id="grid"><div id="grid-wrapper"></div></div>',
    ];

    $element['red'] = [
      '#type' => 'hidden',
      '#title' => $this->t('Red'),
      '#default_value' => $items[$delta]->red ?? NULL,
      '#attributes' => [
        'id' => 'random-picker-red'
      ],
    ];
    $element['green'] = [
      '#type' => 'hidden',
      '#title' => $this->t('Green'),
      '#default_value' => $items[$delta]->green ?? NULL,
      '#attributes' => [
        'id' => 'random-picker-green'
      ],
    ];
    $element['blue'] = [
      '#type' => 'hidden',
      '#title' => $this->t('Blue'),
      '#default_value' => $items[$delta]->blue ?? NULL,
      '#attributes' => [
        'id' => 'random-picker-blue'
      ],
    ];

    return $element;
  }

}
