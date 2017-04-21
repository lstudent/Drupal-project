<?php
/**
 * @file providing the service that say hello world and hello 'given name'.
 *
 */
namespace  Drupal\random_quote;

class RandomQuotes implements IQuoteService {

    protected $quoteServiceUrl;

    /**
     * {@inheritdoc}
     */
    public function __construct() {
       // $this->quoteServiceUrl = 'http://quotes.stormconsultancy.co.uk/random.json';
        // get from config
         $this->quoteServiceUrl = \Drupal::config('random_quote.settings')->get('url');
    }

    /**
     * {@inheritdoc}
     */
    public function getRandomQuote() {
        $client = \Drupal::httpClient();
        $request = $client->get($this->quoteServiceUrl);
        $response = json_decode($request->getBody());
        return $response->quote;
    }
}