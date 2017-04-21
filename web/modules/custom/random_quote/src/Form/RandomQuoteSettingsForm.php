<?php

namespace Drupal\random_quote\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Request;



/**
 * Configure rate settings for the site.
 */
class RandomQuoteSettingsForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'random_quote_settings_form';
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
        $config = $this->config('random_quote.settings');

        $form['url'] = [
            '#type' => 'textfield',
            '#title' =>$this->t('Quote services URL'),
            '#default_value' => $config->get('url'),
        ];


        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
//      $values = $form_state->getValues();
        $this->config('random_quote.settings')
            ->set('Quote services url', $form_state->getValue('Quote services url'))
            ->save();

        $urlQuote = \Drupal::config('random_quote.settings')->get('Quote services url');



    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [
            'random_quote.settings',
        ];
    }
}


