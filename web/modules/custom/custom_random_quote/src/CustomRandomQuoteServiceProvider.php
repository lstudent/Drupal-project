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

        // check if module is enabled?
//        $moduleHandler = \Drupal::service('module_handler');
//        if ($moduleHandler->moduleExists('custom_random_quote')) {
        $definition = $container->getDefinition('random_quote.random_quotes');
        $quoteImplClass = Settings::get('quote_srv_impl', 'Drupal\custom_random_quote\StaticRandomQuoteInterface');
        $definition->setClass($quoteImplClass);
//        }
    }

}