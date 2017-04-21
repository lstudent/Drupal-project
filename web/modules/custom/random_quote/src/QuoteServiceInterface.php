<?php
/**
 * @file providing the service that say hello world and hello 'given name'.
 *
 */
namespace  Drupal\random_quote;

interface QuoteServiceInterface {

    /**
     * Gets a random quote.
     *
     * @return string
     */
    public function getRandomQuote();

}