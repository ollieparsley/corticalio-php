<?php
namespace Corticalio;

use Corticalio\Client;
use Corticalio\Exception;

abstract class Section
{
    /**
     * The configured base client
     *
     * @var Corticalio\Client
     */
    protected $client;

    /**
     * The supplied options
     *
     * @var array
     */
    protected $options;

    /**
     * Contruct the base section
     *
     * The API is split into sections. This is a base class for use by each section
     * 
     * @param Corticalio\Client $client  The API client
     * @param array             $options The supplied options
     * 
     * @return $this
     */
    public function __construct(Client $client, $options = [])
    {
        $this->client = $client;
        $this->options = $options;
    }

    /**
     * The base API client
     *
     * @return Corticalio\Client
     */
    protected function getClient()
    {
        return $this->client;
    }

}
