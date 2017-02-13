<?php

namespace NicolasBeauvais\BotScout;

use GuzzleHttp\Client;

class BotScout
{
    protected $client;

    protected $baseUrl = 'http://botscout.com/test/';

    private $apiKey;

    /**
     * @param \GuzzleHttp\Client $client
     * @param string $apiKey
     */
    public function __construct(Client $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * Test matches all parameters at once.
     *
     * @param string $name
     * @param string $mail
     * @param string $ip
     *
     * @return BotScoutResponse
     */
    public function multi(string $name = null, string $mail = null, string $ip = null)
    {
        return $this->makeRequest('multi', compact('name', 'mail', 'ip'));
    }

    /**
     * Test matches a single item against all fields in the botscout database.
     *
     * @param string $all
     *
     * @return BotScoutResponse
     */
    public function all(string $all)
    {
        return $this->makeRequest('multi', compact('all'));
    }

    /**
     * Test matches a name.
     *
     * @param string $name
     *
     * @return BotScoutResponse
     */
    public function name(string $name = null)
    {
        return $this->makeRequest(null, compact('name'));
    }

    /**
     * Test matches an email.
     *
     * @param string $mail
     *
     * @return BotScoutResponse
     */
    public function mail(string $mail = null)
    {
        return $this->makeRequest(null, compact('mail'));
    }

    /**
     * Test matches an ip.
     *
     * @param string $ip
     *
     * @return BotScoutResponse
     */
    public function ip(string $ip = null)
    {
        return $this->makeRequest(null, compact('ip'));
    }

    /**
     * @param array  $query
     *
     * @return BotScoutResponse
     */
    public function makeRequest(string $type = null, array $query = [])
    {
        if ($type) {
            $query[$type] = null;
        }

        $query['key'] = $this->apiKey;

        return $this->decodeResponse($this->client
            ->get($this->baseUrl, compact('query'))
            ->getBody()
            ->getContents());
    }

    /**
     * @param string $response
     *
     * @return BotScoutResponse
     */
    private function decodeResponse(string $response)
    {
        if (strpos($response, '!') !== false) {
            throw new \Exception($response);
        }

        return new BotScoutResponse($response);
    }
}
