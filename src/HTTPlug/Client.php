<?php

namespace TwoDotsTwice\CVWarehouse\HTTPlug;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Http\Client\HttpClient;
use TwoDotsTwice\CVWarehouse\Channel;
use TwoDotsTwice\CVWarehouse\Client as ClientInterface;
use TwoDotsTwice\CVWarehouse\Credentials;
use TwoDotsTwice\CVWarehouse\Language;
use TwoDotsTwice\CVWarehouse\XML\Parser;

final class Client implements ClientInterface
{
    const BASE_URL = 'https://api.cvwarehouse.com';

    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @var Credentials
     */
    private $credentials;

    /**
     * @var Parser
     */
    private $parser;

    public function __construct(HttpClient $client, Credentials $credentials, Parser $parser)
    {
        $this->client = $client;
        $this->credentials = $credentials;
        $this->parser = $parser;
    }

    public function jobs(Channel $channel, Language $language = null)
    {
        $request = new Request('GET', $this->getUrl($channel, $language));

        $response = $this->client->sendRequest($request);

        return $this->parser->parse($response->getBody()->getContents());
    }

    private function getUrl(Channel $channel, Language $language = null)
    {
        $parts = [
          (string) $this->credentials->getUserName(),
          (string) $this->credentials->getAccessCode(),
          'job',
          (string) $channel,
        ];

        $parts[] = (string) $this->parser->format();

        if ($language) {
            $parts[] = (string) $language;
        }

        return new Uri(self::BASE_URL . '/' . implode('/', $parts));
    }
}
