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
   * Prefix values for the select list.
   */
  const PREFIX = [
    'Dean' => 'Dean',
    'Dr.' => 'Dr.',
    'Mr.' => 'Mr.',
    'Mrs.' => 'Mrs.',
    'Ms.' => 'Ms.',
    'Miss' => 'Miss',
    'Professor' => 'Professor',
    'Other' => 'Other'
  ];

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    // A field may have multiple values if cardinality is not set to 1.
    /** @var \Drupal\link\LinkItemInterface $item */
    $item = $items[$delta];

    // Field widgets can take many different forms. Like the example below, they
    // can be simple implementations with the Drupals Forms API; or they can be
    // complex embedded applications. The key is that the value for each column
    // in the FieldType must be set as a named value on the returned element.
    $element['prefix'] = [
      '#type' => 'select',
      '#title' => $this->t('Prefix'),
      '#options' => self::PREFIX,
      '#default_value' => $items[$delta]->prefix ?? NULL,
      '#empty_option' => '- None -',
      '#empty_value' => '',
      '#required' => FALSE,
      '#attributes' => [
        'id' => 'prefix_selector',
      ],
    ];
    $element['prefix_other'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Specify Other Prefix'),
      '#size' => '20',
      '#states' => [
        'visible' => [
          ':input[id="prefix_selector"]' => ['value' => 'Other'],
        ],
        'required' => [
          ':input[id="prefix_selector"]' => ['value' => 'Other'],
        ],
      ],
      '#default_value' => $items[$delta]->prefix_other ?? NULL,
    ];
    $element['first'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First'),
      '#default_value' => $items[$delta]->first ?? NULL,
    ];
    $element['middle'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Middle'),
      '#default_value' => $items[$delta]->middle ?? NULL,
    ];
    $element['last'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last'),
      '#default_value' => $items[$delta]->last ?? NULL,
    ];
    $element['suffix'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Suffix'),
      '#size' => '20',
      '#default_value' => $items[$delta]->suffix ?? NULL,
    ];
    $element['nickname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Nickname or Preferred Name'),
      '#default_value' => $items[$delta]->nickname ?? NULL,
    ];
    return $element;
  }

}
