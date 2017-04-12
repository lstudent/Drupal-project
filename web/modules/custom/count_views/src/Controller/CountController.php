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
     * @return Drupal renderable array with content.
     */
    public function count_content($name) {
        return array(
            '#type' => 'markup',
            '#markup' => $this->t('Count_views, @name!', ['@name' => $name]),
        );
    }

}