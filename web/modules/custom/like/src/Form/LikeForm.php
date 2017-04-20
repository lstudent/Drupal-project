<?php

namespace Drupal\like\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\like\LikeEvent;

/**
 * Defines the BasicForm class.
 */
class LikeForm extends FormBase
{

    protected $uid;
    protected $nid;
    protected $title;

    public function __construct(){
        $this->uid = \Drupal::currentUser()->id();
        $node = \Drupal::routeMatch()->getParameter('node');
        if ($node) {
            $this->title = $node->getTitle();
            $this->nid = $node->nid->value;
            //drupal_set_message($this->uid . '-' . $this->nid . ' ' . $this->title);
        }

    }

    /**
     * {@inheritdoc}.
     */
    public function getFormId()
    {
        return 'my_like_form';
    }

    /**
     * {@inheritdoc}.
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $likeText = '';
        $likesSum = 0;
      //  dpm('hi');
        $disableLike = false;
        $disableDislike = false;
        $node = \Drupal::routeMatch()->getParameter('node');
        if ($node) {
            if (\Drupal::currentUser()->isAuthenticated()) {
                $userLikes = $this->getUserLikes($this->nid, $this->uid);
                if ($userLikes == 1) {
                    $likeText = 'You Like it';
                    $disableLike = true;
                } elseif($userLikes == -1) {
                    $likeText = 'You Dislike it';
                    $disableDislike = true;
                }
            } else {
                $disableLike = true;
                $disableDislike = true;
            }
            $likesSum = $this->getTotalLikes($this->nid);
        }
       // drupal_set_message($likesSum . '-' . $disableDislike . ' ' . $disableLike);
        //drupal_set_message($userLikes);
        $form = array(
            '#prefix' => '<div id="myform-wrapper">',
            '#suffix' => '</div>'
        );
//        $form_state->setCached(FALSE);
        $form['action'] = [
            '#type' => 'actions',
        ];
        $form['action']['like'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Like'),
            '#button_type' => 'primary',
            '#submit' => ['::submitLike'],
            '#disabled' => $disableLike,
            '#ajax' =>[
                'callback' => '::callbackAjaxRefresh',
                'event' => 'click',
                'wrapper' => 'myform-wrapper',
                'effect' => 'fade',
            ],
        );
        $form['action']['dislike'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Dislike'),
            '#button_type' => 'primary',
            '#submit' => ['::submitLike'],
            '#disabled' => $disableDislike,
            '#ajax' =>[
                'callback' => '::callbackAjaxRefresh',
                'event' => 'click',
                'wrapper' => 'myform-wrapper',
                'effect' => 'fade',
            ],
        );
        $form['total'] = [
            '#type' => 'markup',
            '#markup' => '<span>Total Votes: ' . intval($likesSum) . '</span>',
        ];
        return $form;
    }


    public function getUserLikes($nid, $uid) {
        $db = \Drupal::database();
        $query = $db->select('like_db', 'ldb')->fields('ldb', ['nr_like_dislike']);
        $results = $query->condition('entity_id', $nid)
            ->condition('uid', $uid)
            ->execute()
            ->fetchAssoc();
        if ($results) {
            return $results['nr_like_dislike'];
        }
        return null;
    }

    public function getTotalLikes($nid) {
        $db = \Drupal::database();
        $query = $db->select('like_db', 'ldb')->condition('entity_id', $nid);
        $query->addExpression('sum(nr_like_dislike)', 'likes_sum');
        $results = $query->execute()->fetchAssoc();

        if ($results) {
            return $results['likes_sum'];
        }
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        // Not used.
    }

    public function submitLike(array &$form, FormStateInterface $form_state)
    {
        $likeValue = 1;
        $action = 'like';
        $button_clicked = $form_state->getTriggeringElement()['#value'];
        if ($button_clicked == 'Dislike') {
            $likeValue = -1;
            $action = 'dislike';
        }
        $this->addLike($likeValue, $this->nid, $this->uid);


        $user = \Drupal::currentUser();
        $userName = $user->getAccountName();

        $dispatcher = \Drupal::service('event_dispatcher');
        $event = new LikeEvent($userName, $action, 'book', $this->title);
        $dispatcher->dispatch(LikeEvent::SUBMIT, $event);

        $form_state->setRebuild();

//        return $form;
//      hook_call
     //  \Drupal::moduleHandler()->invokeAll('vote_liked', [$event]);

//        if ($form_state->getTriggeringElement()['#value'] == 'Like') {
//        } else {
//            $likeText = 'You Dislike it';
//            $likeValue = -1;
//            $action = 'dislike';
//        }
    }

    public function addLike($likeValue, $nid, $uid) {
        $db = \Drupal::database();
        $query = $db->select('like_db', 'ldb')->fields('ldb', ['nr_like_dislike']);
        $results = $query->condition('entity_id', $nid)->condition('uid', $uid)->execute()->fetchAssoc();
        if ($results) {
            $fields = array(
                'nr_like_dislike' => (int)$likeValue,
            );
            $db->update('like_db')->fields($fields)->condition('entity_id', $nid)->condition('uid', $uid)->execute();
        } else {
            $fields = array(
                'entity_id' => (int)$nid,
                'uid' => (int)$uid,
                'nr_like_dislike' => (int)$likeValue,
            );
            $db->insert('like_db')->fields($fields)->execute();
        }
    }

    public function callbackAjaxRefresh(array &$form, FormStateInterface $form_state){
        return $form;
    }
//
//    public function likeCallback(array &$form, FormStateInterface $form_state)
//    {
//        return $form;
//        //dpm($form);
//
//
//    }
//
//    public function dislikeCallback(array &$form, FormStateInterface $form_state)
//    {
//        return $form;
////
//    }
}