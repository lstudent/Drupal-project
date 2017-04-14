<?php
/**
 * @file
 * Contains \Drupal\hello\Form\My.
 */

namespace Drupal\hello\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class publish_content extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'new_form_My';
    }

    /**
     * API to return class's students list.
     */

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $nids = \Drupal::entityQuery('node')->condition('type', 'book')->execute();
        $nodes = \Drupal\node\Entity\Node::loadMultiple($nids);

        $array_nodes = [];
        foreach ($nodes as $node) {
            $array_nodes = array_merge($array_nodes, array($node->getTitle() => $node->getTitle()));
            //array_push($array_nodes, $new_item);
        }
        $form['book_title'] = [
            '#type' => 'select',
            '#title' => t('Select the book'),
            '#options' => $array_nodes,
        ];

        $form['publish_mode'] = [
            '#type' => 'select',
            '#title' => t('Publish'),
            '#options' => ['0' => 'Unpublish', '1' => 'Publish'],

        ];
        $form['sticky'] = [
            '#type' => 'select',
            '#title' => t('Sticky'),
            '#options' => ['0' => 'Unsticky', '1' => 'Sticky'],
            ];

        $form['success'] = [
            '#type' => 'success_popup',
            '#value' => t('success'),
            'showCloseButton' => TRUE,
            'closeButtonText' => t('Close'),

        ];

        $form['update'] = [
            '#type' => 'submit',
            '#value' => t('Update'),
            //'#submit' => array('::SubmitUpdate'),
        ];
        $form['delete'] = [
            '#type' => 'submit',
            '#value' => t('Delete'),
            //'#submit' => array('submit_delete'),
            '#attributes' => ['onclick' => 'if(!confirm("Are you sure to delete this book?")){return false;}'],
        ];
        return $form;
    }

    /**
     * {@inheritdoc}
     */


    public function validateForm(array &$form, FormStateInterface $form_state)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {

        $title = $form_state->getValue('book_title');

        $nids = \Drupal::entityQuery('node')->condition('type', 'book')->condition('title', $title)->execute();
        $node = \Drupal\node\Entity\Node::load(array_values($nids)[0]);
        drupal_set_message($node->getTitle());

        $button_clicked = $form_state->getTriggeringElement()['#value'];
        if ($button_clicked == 'Update') {
            drupal_set_message('Update action');
            drupal_set_message($form_state->getValue('publish_mode'));
            drupal_set_message($form_state->getValue('sticky'));
//            $node->setPublished($form_state->getValue('publish_mode'));
//            $node->setSticky($form_state->getValue('sticky'));
        } else {
            drupal_set_message('Delete action');
            $node->delete();
            drupal_set_message(t('The book has been deleted.'));

            }
    }

    public function submit_update(&$form, FormStateInterface $form_state)
    {
        drupal_set_message('1');
    }

    public function submit_delete(&$form, FormStateInterface $form_state)
    {
        drupal_set_message('2');
    }
}

