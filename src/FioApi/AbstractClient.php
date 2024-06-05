<?php

namespace FioApi;

use Composer\CaBundle\CaBundle;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;

abstract class AbstractClient
{
    /**
     * @var string secret token from FIO Internet banking
     */
    protected $token;

    /**
     * @var UrlBuilder
     */
    protected $urlBuilder;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param string $token
     *
     * @return AbstractClient
     */
    public function __construct(string $token, ClientInterface $client = null)
    {
        $this->token = $token;
        $this->urlBuilder = new UrlBuilder($token);
        $this->client = $client;
    }

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        if (!$this->client) {
            $this->client = new Client([
                RequestOptions::VERIFY => CaBundle::getSystemCaRootBundlePath()
            ]);
        }

        return $this->client;
    }

    /**
     * Get token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}
