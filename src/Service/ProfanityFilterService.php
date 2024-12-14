<?php

namespace App\Service;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface; // Add this import

class ProfanityFilterService
{
    private ClientInterface $client;
    private RequestFactoryInterface $requestFactory;
    private UriFactoryInterface $uriFactory; // Add UriFactoryInterface
    private string $apiUrl = 'https://api.api-ninjas.com/v1/profanityfilter?text={}';
    private string $apiKey = 'aJT91XUVz9fRGbVPeNLgig==eoMLzFULfL3SQ2p9'   ; // Replace with your actual API key

    public function __construct(ClientInterface $client, RequestFactoryInterface $requestFactory, UriFactoryInterface $uriFactory)
    {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
        $this->uriFactory = $uriFactory; // Initialize the UriFactoryInterface
    }

    public function filterProfanity(string $text): array
    {
        try {
            $uri = $this->uriFactory->createUri($this->apiUrl . '?text=' . urlencode($text)); // Create the URI object

            $request = $this->requestFactory->createRequest('GET', $uri)
                ->withHeader('X-Api-Key', $this->apiKey)
                ->withHeader('Accept', 'application/json');

            $response = $this->client->sendRequest($request);

            $data = json_decode($response->getBody()->getContents(), true);

            return [
                'censored_text' => $data['censored_text'] ?? '',
                'contains_profanity' => $data['contains_profanity'] ?? false,
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }
}
