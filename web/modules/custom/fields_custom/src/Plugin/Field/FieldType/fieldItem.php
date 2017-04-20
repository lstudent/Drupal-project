<?php

namespace Drupal\fields_custom\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\fields_custom\Plugin\Validation\Constraint;

/**
 * Plugin implementation of the 'isbn' field type.
 *
 * @FieldType(
 *   id = "isbn",
 *   label = @Translation("ISBN Field"),
 *   module = "fields_custom",
 *   description = @Translation("Add ability to insert an ISBN field."),
 *   default_widget = "isbn_widget",
 *   default_formatter = "isbn_formatter"
 * )
 */
class fieldItem extends FieldItemBase {
    /**
     * {@inheritdoc}
     */
    public static function schema(FieldStorageDefinitionInterface $field_definition) {
        return array(
            'columns' => array(
                'value' => array(
                    'type' => 'text',
                    'size' => 'tiny',
                    'not null' => FALSE,
                ),
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
        $properties['value'] = DataDefinition::create('string')
            ->setLabel(t('ISBN value'))->addConstraint('Length', array('min' => 10, 'max' => 20))->addConstraint('Isbn', []);

        return $properties;

    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty() {
        $value = $this->get('value')->getValue();
        return $value === NULL || $value === '';
    }
}
