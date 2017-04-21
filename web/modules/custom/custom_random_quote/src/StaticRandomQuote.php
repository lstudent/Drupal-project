<?php
/**
 * @file providing the service that say hello world and hello 'given name'.
 *
 */
namespace  Drupal\custom_random_quote;

use Drupal\random_quote\QuoteServiceInterface;

class StaticRandomQuote implements QuoteServiceInterface {

    protected static $quotes = array("Quote1", "Quote2", "Quote3", "Quote4", "Quote5");

    /**
     * {@inheritdoc}
     */
    public function getRandomQuote() {
        return self::$quotes[array_rand(self::$quotes)];
    }
}