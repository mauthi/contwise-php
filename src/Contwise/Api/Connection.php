<?php

namespace Contwise\Api;

use Contwise\Exceptions\ContwiseException;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\HandlerStack;
use GuzzleRetry\GuzzleRetryMiddleware;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Connection.
 *
 * @namespace    Contwise\Api
 * @author     Mauthi <mauthi@gmail.com>
 */
class Connection
{
    /**
     * Harvest options.
     *
     * @var array
     */
    protected $options = [
        'apiUrl' => '',
        'apiKey' => '',
        'editApiKey' => '',
        'debug' => false,
    ];

    /**
     * The HTTP client to use for the requests.
     *
     * @var GuzzleClient
     */
    private $httpClient;

    /**
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->setOptions($options);
    }

    /**
     * Set the http client.
     *
     * @param GuzzleClient $client
     */
    public function setHttpClient(GuzzleClient $client)
    {
        $this->httpClient = $client;
    }

    /**
     * Get a fresh instance of the http client.
     *
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient() :GuzzleClient
    {
        if (is_null($this->httpClient)) {
            $stack = HandlerStack::create();
            $stack->push(GuzzleRetryMiddleware::factory());
            $this->httpClient = new GuzzleClient([
                'handler' => $stack,
                'base_uri' => $this->getOption('apiUrl'),
                'query' => [
                    'apiKey' => $this->getOption('apiKey'),
                    'editApiKey' => $this->getOption('editApiKey'),
                ],
                'on_retry_callback' => function ($attemptNumber, $delay, $request, $options, $response) {
                    if ($this->getOption('debug')) {
                        echo sprintf(
                            "Retrying request to %s.  Server responded with %s.  Will wait %s seconds.  This is attempt #%s\n",
                            $request->getUri()->getPath(),
                            $response->getStatusCode(),
                            number_format($delay, 2),
                            $attemptNumber
                        );
                    }
                },
            ]);
        }

        return clone $this->httpClient;
    }

    /**
     * Builds and performs a request.
     *
     * @param  array $body
     * @param  array $options
     * @return array
     */
    public function request(String $method, String $url, array $body = [], array $options = [])
    {
        $client = $this->getHttpClient();
        if (!isset($options['headers']['Content-Type'])) {
            $options['headers']['Content-Type'] = 'application/json';
        }
        // Set headers to accept only json data.
        $options['headers']['Accept'] = 'application/json';
        // $options['debug'] = true;
        // $options['auth'] = [$this->getOption('email'), $this->getOption('apiKey')];
        switch ($options['headers']['Content-Type']) {
            case 'multipart/form-data':
                $options['multipart'] = $body;
                break;
            case 'application/json';
            default:
                $options['json'] = $body;
                break;
        }
        
        // print_r($options);
        $response = $client->request($method, $url, $options);

        switch ($response->getStatusCode()) {
            case 200:
                // everything ok
                $result = json_decode($response->getBody(), true);
                // print_r(array_keys($result));
                return $result;

            default:
                // all other cases
                throw new ContwiseException('Status Code of Response = '.$response->getStatusCode()."\nBody: ".print_r($body, true));
        }
    }

    /**
     * Set the options.
     *
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Get a single option value.
     *
     * @param  ar $option
     * @throws Exception
     * @return string
     */
    public function getOption($option)
    {
        if (!array_key_exists($option, $this->options)) {
            throw new Exception("The requested option [$option] has not been set or is not a valid option key.");
        }

        return $this->options[$option];
    }
}
