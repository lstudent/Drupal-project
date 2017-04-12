<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;




/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "hello_block",
 *   admin_label = @Translation("Hello block"),
 * )
 */
class HelloBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {
        $account = \Drupal::currentUser();
        $name = $account->getAccountName();
        if ($account->isAuthenticated()) {
            // User is logged in.
            return array(
                '#markup' => $this->t('Hello ' . $name . '!'),
            );
        }
        else {
            return array(
                '#markup' => $this->t('Hello anonymous!'),
            );
        }
    }

}
