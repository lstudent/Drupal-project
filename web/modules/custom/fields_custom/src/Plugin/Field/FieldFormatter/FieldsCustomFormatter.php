<?php

namespace Drupal\fields_custom\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;


/**
 * Plugin implementation of the 'isbn_default' formatter.
 *
 * @FieldFormatter(
 *   id = "isbn_formatter",
 *   label = @Translation("Isbn text"),
 *   field_types = {
 *     "isbn"
 *   }
 * )
 */
class FieldsCustomFormatter extends FormatterBase {

    /**
     * {@inheritdoc}
     */
    public function settingsSummary() {
        $summary = array();
        $settings = $this->getSettings();

        $summary[] = t('Displays the ISBN string.');

        return $summary;
    }

    /**
     * {@inheritdoc}
     */
    public function viewElements(FieldItemListInterface $items, $langcode) {
        $element = array();

        foreach ($items as $delta => $item) {
            // Render each element as markup.
            $element[$delta] = array(
                '#type' => 'markup',
                '#markup' => $item->value,
            );
        }

        return $element;
    }



}
