<?php

namespace Drupal\count_views\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Count_views' Block.
 *
 * @Block(
 *   id = "count_views_block",
 *   admin_label = @Translation("Count Views block"),
 * )
 */
class count_views_block extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {
        $only_node_route = 'entity.node.canonical';
        if(\Drupal::routeMatch()->getRouteName() != $only_node_route){
            return;
        }
        $node = \Drupal::routeMatch()->getParameter('node');
      $nid = $node->nid->value;
     //   $uri = \Drupal::request()->getRequestUri();
        $text = null;
        $db = \Drupal::database();
        $query = $db->select('count_db','cdb')->fields('cdb',['nr_views','nr_views_today','last_user','last_time']);
        $results = $query->condition('hook_id', $nid)->execute()->fetchAssoc();
        $timestamp = time();

      if ($results){
          $views_today = $results['nr_views_today'];
          if(Date('d/m/Y') != Date('d/m/Y', $results['last_time']))
          {
              $views_today = 0;
          }
           $fields = array(
               'last_time' => (int) $timestamp,
                'nr_views' => (int) $results['nr_views']+1,
                'nr_views_today' => (int) $views_today+1,
                'last_user' => (string) \Drupal::currentUser()->getAccountName(),
            );
          $db->update('count_db')->fields($fields)->condition('hook_id',$nid)->execute();

          $text = 'Total views: '.$results['nr_views'].'<br/>Views today:'.$views_today.'<br/>Last user: '.$results['last_user'].'<br/>Last time: '.Date('d/m/Y - H:i', $fields['last_time']);
      } else {
            $fields = array(
                'hook_id' => $nid,
                'last_time' => (int) $timestamp,
                'nr_views' => (int) 1,
                'nr_views_today' => (int) 1,
                'last_user' => (string) \Drupal::currentUser()->getAccountName(),
            );
          $db->insert('count_db')->fields($fields)->execute();
          $text = 'Total views: 0<br/>Views today: 0<br/>Last user: '.\Drupal::currentUser()->getAccountName().'<br/>Last time: '.Date('d/m/Y - H:i', $timestamp);
      }

        return array(
            '#markup' => $this->t((string)$text),
        );


    }
}
