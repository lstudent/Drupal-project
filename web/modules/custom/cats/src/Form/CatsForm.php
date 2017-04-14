<?php

namespace Drupal\cats\Form;

use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\AjaxResponse;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

/**
 * Defines the BasicForm class.
 */
class CatsForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'cats_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['load_more'] = array(
      '#type' => 'submit',
      '#value' => t('Load more'),
      '#ajax' => array(
        'event' => 'click',
        'method' => 'append',
        'wrapper'=> 'cats_container',
        'callback' => '::getNextCats',
        'progress' => array(
          'type' => 'throbber',
          'message' => 'Updating...',
        ),
      ),
      '#prefix' => '<div id="cats_container"></div>',
    );
//    $form['tag_div'] = array(
//      '#theme' => 'image',
//      '#tag' => 'div',
//      '#uri' => 'http://25.media.tumblr.com/tumblr_m1uu97ZNDT1qd477zo1_250.jpg',
//  );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

  public function getNextCats2(array &$form, FormStateInterface $form_state) {
    $client = \Drupal::httpClient();
    $response = $client->get('http://thecatapi.com/api/images/get?format=src&size=small&results_per_page=1');

    $responseContent = $response->getBody()->getContents();
    dpm($responseContent);
        $elements['tag_div'] = array(
            '#theme'=>'image',
            '#tag' => 'div',
            '#uri' => $responseContent,
        );

    return $elements;
  }

    public function getNextCats(array &$form, FormStateInterface $form_state) {
        $client = \Drupal::httpClient();
        $response = $client->get('http://thecatapi.com/api/images/get?format=xml&size=small&results_per_page=5');

        $responseXML = $response->getBody()->getContents();
        $xmlObject = simplexml_load_string($responseXML);

        $uris = $xmlObject->xpath("/response/data/images/image/url");
        $i = 0;
        $elements = [];
        foreach ($uris as $uri) {
            $elements['tag_div' . $i++] = array(
                '#theme'=>'image',
                '#tag' => 'div',
                '#uri' => (string) $uri,
            );
        }
        return $elements;
    }

}

