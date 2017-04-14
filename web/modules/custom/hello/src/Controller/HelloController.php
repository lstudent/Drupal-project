<?php

/**
 * @file
 * Contains \Drupal\helo\Controller\HelloController.
 */

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller routines for page example routes.
 */
class HelloController extends ControllerBase {

    /**
     * Hello page.
     *
     * @return Drupal renderable array with content.
     */
    public function hello_content($name) {
        return array(
            '#type' => 'markup',
            '#markup' => $this->t('Hello, @name!', ['@name' => $name]),
        );
    }

}