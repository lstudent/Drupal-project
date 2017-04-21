<?php


namespace  Drupal\random_quote;

use GuzzleHttp\Client;

class RandomQuotes implements QuoteServiceInterface {

    protected $quoteServiceUrl;
    protected $httpClient;

    /**
     * {@inheritdoc}
     */
    public function __construct(Client $client) {
       // $this->quoteServiceUrl = 'http://quotes.stormconsultancy.co.uk/random.json';
        $this->quoteServiceUrl = \Drupal::config('random_quote.settings')->get('url');
        $this->httpClient = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function getRandomQuote() {
        $request = $this->httpClient->get($this->quoteServiceUrl);
        $response = json_decode($request->getBody());
        return $response->quote;
    }
}