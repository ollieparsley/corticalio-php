<?php
namespace Corticalio;

use Corticalio\Exception\NotFoundException;
use Corticalio\Exception;
use Corticalio\Section\Retinas;
use Corticalio\Section\Terms;
use Corticalio\Section\Compare;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request;

class Client
{
    /**
     * The API key to access the REST API
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Base URL for the API (must include trailing slash)
     *
     * @var string
     */
    protected $baseUrl = 'https://api.cortical.io/rest/';

    /**
     * A Guzzle HTTP client
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $httpClient;

    /**
     * Sections
     *
     * @var \Corticalio\Section
     */
    public $retinas;
    public $terms;
    public $compare;

    /**
     * Contruct the client
     *
     * This is the main entrypoint into the API client. You can access the get/post public methods
     * yourself, or use the helper methods
     * 
     * @param array $options The API key (api_key), base URL (optional base_url) and HTTP client (optional http_client) 
     * 
     * @return $this
     */
    public function __construct($options = [])
    {
        if (!isset($options['api_key'])) {
            throw new Exception("An API key is required");
        }
        $this->apiKey = $options['api_key'];

        if (isset($options['base_url'])) {
            $this->baseUrl = $options['base_url'];
        }

        if (!isset($options['http_client'])) {
            $this->httpClient = new HttpClient([
                'timeout'  => 30.0,
                'verify' => true,
                'http_errors' => false,
            ]);
        } else if (!is_a($options['http_client'], '\GuzzleHttp\ClientInterface')){
            throw new Exception('The http_client option must be a Guzzle\Client');
        } else {
            $this->httpClient = $options['http_client'];
        }

        // Instantiate the sections
        $this->retinas = new Retinas($this);
        $this->terms = new Terms($this);
        $this->compare = new Compare($this);
    }

    /**
     * Get the HTTP client
     * 
     * @return \GuzzleHttp\ClientInterface
     */
    protected function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * Make a GET request to the API
     * 
     * Returns a JSON decoded response body
     *
     * @param string $endpoint The API endpoint without a starting slash
     * @param array  $params   The GET parameters to be used with the request
     * 
     * @return object
     */
    public function get($endpoint, $params=[])
    {
        return $this->makeApiRequest($endpoint, 'GET', $params);
    }

    /**
     * Make a POST request to the API
     * 
     * Returns a JSON decoded response body
     *
     * @param string $endpoint   The API endpoint without a starting slash
     * @param mixed  $postParams The POST parameters to be used with the request
     * @param array  $getParams  The GET parameters to be used with the request
     * 
     * @return object
     */
    public function post($endpoint, $postParams, $getParams = null)
    {
        return $this->makeApiRequest($endpoint, 'POST', $getParams, $postParams);
    }

    /**
     * Actually make the request to the API
     * 
     * Returns a JSON decoded response body
     *
     * @param string $endpoint   The API endpoint without a starting slash
     * @param string $method     The HTTP method
     * @param array  $getParams  The GET parameters to be used with the request
     * @param mixed  $postParams The POST parameters to be used with the request
     * 
     * @return object
     */
    protected function makeApiRequest($endpoint, $method, $getParams, $postParams = null)
    {
        $url = $this->baseUrl . $endpoint;
        if ($getParams) {
            $url .= '?' . http_build_query($getParams);
            $param = null;
        }
        $requestOptions = [
            'headers' => [
                'api-key' => $this->apiKey,
                'User-Agent' => 'ollieparsley/corticalio PHP Client 1.0.0',
            ]
        ];

        if ($method === 'POST') {
            if (is_string($postParams)) {
                $requestOptions['body'] = $postParams;
                $requestOptions['headers']['Content-Type'] = 'application/json';
            } else if (is_array($postParams)) {
                $requestOptions['form_params'] = $postParams;
            }
        }

        $httpClient = $this->getHttpClient();

        $request = new Request($method, $url);

        // Send the request and get the response
        $response = $httpClient->send($request, $requestOptions);
        $statusCode = $response->getStatusCode();
        $body = trim($response->getBody());

        if ($statusCode === 404) {
            throw new NotFoundException("Error $statusCode: $body");
        }
        if ($statusCode !== 200 && $statusCode !== 204) {
            throw new Exception("Error $statusCode: $body");
        }

        if ($statusCode === 204) {
            return null;
        }

        return json_decode($body);
    }

}
