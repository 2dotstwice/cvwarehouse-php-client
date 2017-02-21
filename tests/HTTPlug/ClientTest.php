<?php

namespace TwoDotsTwice\CVWarehouse\HTTPlug;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as HttpClient;
use TwoDotsTwice\CVWarehouse\Channel;
use TwoDotsTwice\CVWarehouse\Credentials;
use TwoDotsTwice\CVWarehouse\Credentials\AccessCode;
use TwoDotsTwice\CVWarehouse\Credentials\UserName;
use TwoDotsTwice\CVWarehouse\Job;
use TwoDotsTwice\CVWarehouse\Job\Description;
use TwoDotsTwice\CVWarehouse\Job\Id;
use TwoDotsTwice\CVWarehouse\Job\Name;
use TwoDotsTwice\CVWarehouse\JobCollection;
use TwoDotsTwice\CVWarehouse\Language;
use TwoDotsTwice\CVWarehouse\XML\Parser;
use TwoDotsTwice\CVWarehouse\XML\Version110Parser;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var Credentials
     */
    private $credentials;

    /**
     * @var Parser
     */
    private $parser;

    public function setUp()
    {
        $this->httpClient = new HttpClient();
        $this->parser = new Version110Parser();
        $this->credentials = new Credentials(
            new UserName('JohnDoe'),
            new AccessCode('ed5f5538-254c-4941-aaaa-c809e8a4d030')
        );

        $this->client = new Client($this->httpClient, $this->credentials, $this->parser);
    }

    public function testJobs()
    {
        $xml = file_get_contents(__DIR__ . '/../samples/jobs-1-10.xml');
        $xmlResponse = new Response(200, [], $xml);
        $this->httpClient->addResponse($xmlResponse);

        $jobs = $this->client->jobs(Channel::ownWebsite(), Language::dutchBelgium());

        $requests = $this->httpClient->getRequests();
        $this->assertCount(1, $requests);
        $this->assertSame('GET', $requests[0]->getMethod());
        $this->assertSame('https', $requests[0]->getUri()->getScheme());
        $this->assertSame('api.cvwarehouse.com', $requests[0]->getUri()->getHost());
        $this->assertSame(
            '/JohnDoe/ed5f5538-254c-4941-aaaa-c809e8a4d030/job/Own_website/XML1_10/nl-BE',
            $requests[0]->getUri()->getPath()
        );

        $this->assertInstanceOf(JobCollection::class, $jobs);
        $this->assertCount(7, $jobs);

        $jobs = iterator_to_array($jobs);

        /** @var Job[] $jobs */
        $this->assertEquals(new Id('132153'), $jobs[0]->getId());
        $this->assertEquals(new Name('Directeur Personeel & Organisatie'), $jobs[0]->getName());
        $this->assertEquals(
            new Description(file_get_contents(__DIR__ . '/../samples/jobs-1-10-expected-description.html')),
            $jobs[0]->getDescription()
        );

        $this->assertEquals(
            new Job\Url('http://candidate.cvwarehouse.com/Apply/132153?channel=cvwarehouse.com&lang=nl-BE&t=fo'),
            $jobs[0]->getUrls()->getApplicationBranded()
        );

        $this->assertEquals('2017-02-14T23:59:59+01:00', $jobs[0]->getExpirationDate()->format(DATE_W3C));

        $this->assertEquals(new Id('131139'), $jobs[1]->getId());
        $this->assertEquals(new Name('Hoofdverpleegkundige voor WZC Ter Putkapelle'), $jobs[1]->getName());
        $this->assertEquals(
            new Job\Url('http://candidate.cvwarehouse.com/Apply/131139?channel=cvwarehouse.com&lang=nl-BE&t=fo'),
            $jobs[1]->getUrls()->getApplicationBranded()
        );
    }
}
