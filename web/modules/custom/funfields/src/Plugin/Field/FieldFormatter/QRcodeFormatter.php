<?php

namespace Drupal\funfields\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the QR Code formatter.
 *
 * @FieldFormatter(
 *   id = "qr_formatter",
 *   label = @Translation("QR Code"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class QRcodeFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    // Loop over the items as the field may have multiple values.
    /** @var \Drupal\link\LinkItemInterface $item $item */
    foreach ($items as $delta => $item) {
      $destination = rawurlencode($item->getUrl()->toString());
      $element[$delta] = [
        '#theme' => 'image',
        '#uri' => "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={$destination}%2F&choe=UTF-8",
      ];
    }

    return $element;
  }

}
