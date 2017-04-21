<?php

namespace Drupal\random_quote\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\random_quote\IQuoteService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\Cache;


/**
 * Provides a 'random_quote' Block.
 *
 * @Block(
 *   id = "random_quote_block",
 *   admin_label = @Translation("Random quote block"),
 * )
 */
class random_quote_block extends BlockBase implements ContainerFactoryPluginInterface {
    protected $quoteService;

    public function __construct(array $configuration, $plugin_id, $plugin_definition, IQuoteService $quoteService) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->quoteService = $quoteService;
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        // try to read services name from config here
        return new static(
                $configuration,
                $plugin_id,
                $plugin_definition,
                $container->get('random_quote.random_quotes')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build() {


        $quoteText = $this->quoteService->getRandomQuote();
//        $quoteText = 'text';

        return array(
            '#markup' => $this->t($quoteText),

        );

    }

    /**
     * {@inheritdoc}
     */
    public function getCacheMaxAge() {
        return 0;
    }
}
