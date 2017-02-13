<?php

namespace TwoDotsTwice\CVWarehouse\XML;

use SimpleXMLElement;
use TwoDotsTwice\CVWarehouse\Job;
use TwoDotsTwice\CVWarehouse\Job\Description;
use TwoDotsTwice\CVWarehouse\Job\Id;
use TwoDotsTwice\CVWarehouse\Job\Name;
use TwoDotsTwice\CVWarehouse\Job\Url;
use TwoDotsTwice\CVWarehouse\Job\Urls;
use TwoDotsTwice\CVWarehouse\JobCollection;
use Webmozart\Assert\Assert;

class Version110Parser implements Parser
{
    const NS = 'http://www.cvwarehouse.com/schemas/cvwarehouse-job-1-10';

    public function format()
    {
        return new Format('XML', '1.10');
    }

    public function parse($xml)
    {
        Assert::string($xml);

        // The XML sometimes is not well-formed. Replace some things here we
        // know that are wrong.
        $replacements = [
          '&ltlt;' => '≪',
        ];

        $xml = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $xml
        );

        $dom = simplexml_load_string($xml, SimpleXMLElement::class, 0, self::NS);

        $jobs = [];

        foreach ($dom->job as $jobElement) {
            $id = new Id((string) $jobElement->attributes()->id);
            $name = new Name(trim((string) $jobElement->name));
            $description = new Description((string) $jobElement->description);

            $applicationUrlBranded = new Url($jobElement->urls->applicationUrlBranded);

            $urls = new Urls($applicationUrlBranded);

            $job = new Job($id, $name, $description, $urls);

            $jobs[] = $job;
        }

        return new JobCollection(...$jobs);
    }
}
