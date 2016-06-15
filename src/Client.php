<?php
/**
 * All rights reserved. No part of this code may be reproduced, modified,
 * amended or retransmitted in any form or by any means for any purpose without
 * prior written consent of Mizmoz Limited.
 * You must ensure that this copyright notice remains intact at all times
 *
 * @package Mizmoz
 * @copyright Copyright (c) Mizmoz Limited 2016. All rights reserved.
 */

namespace Mizmoz\API;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class Client
{
    /**
     * Request methods
     */
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';

    /**
     * Content types
     */
    const CONTENT_JSON = 'application/json';

    /**
     * @var string
     */
    private $authId;

    /**
     * @var string
     */
    private $authKey;

    /**
     * Base url for the API
     *
     * @var string
     */
    private $baseUrl;

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Init with your Auth ID and Auth key
     * @see https://www.mizmoz.com/app/access/api
     *
     * @param string $authId
     * @param string $authKey
     * @param string $baseUrl
     */
    public function __construct($authId, $authKey, $baseUrl = 'https://www.mizmoz.com/api/2.0/')
    {
        $this->authId = $authId;
        $this->authKey = $authKey;
        $this->baseUrl = $baseUrl;
    }

    /**
     * Get the request headers
     *
     * @param CommandInterface $command
     * @return array
     */
    public function getHeaders(CommandInterface $command)
    {
        return [
            'x-authid' => $this->authId,
            'x-authkey' => $this->authKey,
            'signature' => Signer::sign($command, $this->authKey),
            'content-type' => $command->getContentType()
        ];
    }

    /**
     * Get the client for making request
     *
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        if (! $this->client) {
            $this->client = new \GuzzleHttp\Client();
        }

        return $this->client;
    }

    /**
     * Set the client
     *
     * @param \GuzzleHttp\Client $client
     * @return $this
     */
    public function setClient(\GuzzleHttp\Client $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Execute the command
     *
     * @param CommandInterface $command
     * @return mixed
     */
    public function execute(CommandInterface $command)
    {
        $request = new Request(
            $command->getRequestMethod(),
            $this->baseUrl . $command->getRequestUrl(),
            $this->getHeaders($command),
            $command->getRequestJson()
        );

        $response = $this->getClient()->send($request);

        // return the response as a json object
        return json_decode($response->getBody()->getContents());
    }
}
