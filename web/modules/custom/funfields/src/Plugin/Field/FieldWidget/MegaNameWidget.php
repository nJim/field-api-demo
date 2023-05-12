<?php

namespace Drupal\funfields\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a widget for the Mega Name field.
 *
 * Field widgets are used to render the field inside forms. For this example,
 * the MegaName field has multiple parts, so the accompanying widget needs a
 * different text input to edit each of the values.
 *
 * @FieldWidget(
 *   id = "meganame_widget",
 *   label = @Translation("Meganame widget"),
 *   field_types = {
 *     "meganame"
 *   }
 * )
 */
class MegaNameWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    $element['prefix'] = [
      '#type' => 'select',
      '#title' => $this->t('Prefix'),
      '#options' => [
        'Dean',
        'Dr.',
        'Mr.',
        'Mrs.',
        'Ms.',
        'Miss',
        'Professor',
        'Other'
      ],
      '#default_value' => $this->getSetting('default_country'),
      '#description' => $this->t('Default country for phone number input.'),
      '#empty_option' => '- None -',
      '#empty_value' => '',
      '#required' => FALSE,
    ];

    return $element;
  }

}
