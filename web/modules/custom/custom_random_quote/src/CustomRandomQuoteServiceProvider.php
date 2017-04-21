<?php

namespace  Drupal\custom_random_quote;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Drupal\Core\Site\Settings;

class CustomRandomQuoteServiceProvider extends ServiceProviderBase {

    /**
     * {@inheritdoc}
     */
    public function alter(ContainerBuilder $container) {
        $definition = $container->getDefinition('random_quote.random_quotes');
        $quoteImplClass = Settings::get('quote_srv_impl', 'Drupal\custom_random_quote\StaticRandomQuote');
        $definition->setClass($quoteImplClass);
    }

}