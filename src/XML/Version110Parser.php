<?php

namespace TwoDotsTwice\CVWarehouse\XML;

use Carbon\Carbon;
use DateTimeImmutable;
use DateTimeZone;
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

            if (isset($jobElement->expirationDate) && !isset($jobElement->options->spontaneousApp)) {
                $expirationDate = $this->parseExpirationDate((string)$jobElement->expirationDate);

                if ($expirationDate) {
                    $job = $job->withExpirationDate($expirationDate);
                }
            }

            $jobs[] = $job;
        }

        return new JobCollection(...$jobs);
    }

    /**
     * Currently the expiration date uses a non-standard based format.
     *
     * e.g. 2017-02-15 12:00:00 which actually means 2017-02-15T00:00
     *
     * @param string $dateAsString
     *
     * @return null|DateTimeImmutable
     */
    private function parseExpirationDate($dateAsString)
    {
        $match = preg_match('@^(?<year>\d{4})-(?<month>\d{2})-(?<day>\d{2})\s@', (string) $dateAsString, $matches);

        if (!$match) {
            return null;
        }

        $correctedDateAsString =
            "{$matches['year']}-{$matches['month']}-{$matches['day']} 12:00:00";

        $date = Carbon::createFromFormat(
            'Y-m-d G:i:s',
            $correctedDateAsString,
            new DateTimeZone('Europe/Brussels')
        );

        $date->subDay(1)->endOfDay();

        return DateTimeImmutable::createFromMutable($date);
    }
}
