<?php

namespace Drupal\rating\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Request;



/**
 * Configure rate settings for the site.
 */
class RatingSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'rating.settings',
    ];
  }
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'rating_settings_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
$config = $this->config('rating.settings');

    $form['Node_Coefficient'] = [
      '#type' => 'number',
      '#title' =>$this->t('Node coefficient'),
      '#default_value' => $config->get('Node_Coefficient'),
    ];

    $form['Comment_Coefficient'] = [
      '#type' => 'number',
      '#title' => t('Comment coefficient'),
      '#default_value' => $config->get('Comment_Coefficient'),
    ];


     return parent::buildForm($form, $form_state);
  }



  /**
   * {@inheritdoc}
   */
    public function submitForm(array &$form, FormStateInterface $form_state) {
//      $values = $form_state->getValues();
      $this->config('rating.settings')
        ->set('Node_Coefficient', $form_state->getValue('Node_Coefficient'))
        ->set('Comment_Coefficient', $form_state->getValue('Comment_Coefficient'))
        ->save();

      $bookCoef = \Drupal::config('rating.settings')->get('Node_Coefficient');
      $commentsCoef = \Drupal::config('rating.settings')->get('Comment_Coefficient');

      $nids = \Drupal::entityQuery('node')->condition('type', 'book')->execute();
      $nodes = \Drupal\node\Entity\Node::loadMultiple($nids);

      $ratings = [];
      foreach ($nodes as $node) {
        $tid = $node->get('field_add_genres')->target_id;
        if ($tid != null) {
          $categoryRating = 0;
          if (array_key_exists($tid, $ratings)) {
            $categoryRating = $ratings[$tid];
          }
          $categoryRating += $bookCoef;
          $nid = $node->nid->value;
          $commentsCount = \Drupal::entityQuery('comment')->condition('entity_id', $nid)->condition('entity_type', 'node')->count()->execute();
          $categoryRating += $commentsCount * $commentsCoef;
          $ratings[$tid] = $categoryRating;
        }
      }
      foreach ($ratings as $tid => $rating) {
        $term = \Drupal\taxonomy\Entity\Term::load($tid);
        $term->get('field_category_rating')->setValue($rating);
        $term->save();
      }
  }
}


