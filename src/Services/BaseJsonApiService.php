<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

/**
 * This class is reponsible for making api request using the Guzzle library.
 * 
 * It also, handles some level of exceptions and makes our api return appropriate response
 * with the right status code which is expected to be useful for client consumption.
 * 
 */
class BaseJsonApiService
{
    /**
    * @var string
    * 
    */
    private string $url;

    /**
    * @var array
    * 
    */
    private array $headers;

    /**
    *  Client
    * 
    */
    private Client $client;

    /**
    * Boots the json api service with the base url and some set of required headers.
    * 
    */
    public function __construct(string $url = 'https://reqres.in/api', array $headers = [])
    {
        $this->url = $url;

        if (!empty($headers)) {
            $this->setHeader($headers);
        }

        $this->headers['Accept'] = 'application/json';
        $this->headers['Content-type'] = 'application/json';

        $this->client = new Client();
    }

    /**
    * Sets the headers dynamically
    * 
    * @param array $headers
    */
    private function setHeader(array $headers)
    {
        foreach ($headers as $key => $value) {
            $this->headers[$key] = $value;
        }
    }

    /**
    * Sends GET request to api
    */
    public function get(string $resource, array $data = [])
    {
        return $this->call($resource, 'GET', $data);
    }

    /**
     * Send request via the Guzzle library
     */
    private function call(string $resource, string $type = 'GET', array $data = [])
    {
        $url = $this->url.'/'.$resource;

        try {

            $response = $this->client->request(
                $type, $url, [
                    'json' => $data,
                    'headers' => $this->headers,
                ]
            );

        } catch (ClientException | GuzzleException $exception) {
            // sets the status code for the client
            http_response_code($exception->getResponse()->getStatusCode());

            return [
                'response' => json_decode($exception->getResponse()->getBody()->getContents(), true),
                'status' => $exception->getResponse()->getStatusCode()
            ];
        }


        if ($response->getStatusCode() >= 200 || $request->getStatusCode() < 300) {
            // sets the status code for the client
            http_response_code($response->getStatusCode());

            $body = $response->getBody();

            return [
                'response' => json_decode($response->getBody(), true),
                'status' => $response->getStatusCode()
            ];
        }

        return json_encode([
            'response' => $response->getBody()->getContents(),
            'status' => $response->getStatusCode(),
            'message' => $response->getBody()->getContents(),
        ]);
    }
}