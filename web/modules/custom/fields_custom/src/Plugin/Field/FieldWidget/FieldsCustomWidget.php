<?php

namespace Drupal\fields_custom\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;


/**
 * Plugin implementation of the 'isbn' widget.
 *
 * @FieldWidget(
 *   id = "isbn_widget",
 *   module = "fields_custom",
 *   label = @Translation("Format and validate ISBN fields"),
 *   field_types = {
 *     "isbn"
 *   }
 * )
 */
class FieldsCustomWidget extends WidgetBase {

    /**
     * {@inheritdoc}
     */
    public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
        $value = isset($items[$delta]->value) ? $items[$delta]->value : '';
        $element += array(
            '#type' => 'textfield',
            '#default_value' => $value,
            '#size' => 13,
            //'#mask' => 'xxx-x-xxxxx-xxx-x',
            '#placeholder' => 'xxx-x-xxxxx-xxx-x',
            '#required' => TRUE,
            '#element_validate' => array(
                array($this, 'validate'),
            ),
        );
        return array('value' => $element);
    }

    /**
     * Validate the color text field.
     */
 public function validate($element, FormStateInterface $form_state) {

    }
}
