<?php

/**
 * @file
 * Contains \Drupal\helo\Controller\HelloController.
 */

namespace Drupal\count_views\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller routines for page example routes.
 */
class CountController extends ControllerBase {

    /**
     * Hello page.
     *
     *
     */
    public function count_content($name) {
        return array(
            '#theme' => 'count_twig',
            '#last_time' => $this->t('value'),
            '#nr_views' => $this->t('value'),
            '#nr_views_today' => $this->t('value'),
            '#last_user' => $this->t('value'),
        );
    }

}