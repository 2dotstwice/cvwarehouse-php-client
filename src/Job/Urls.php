<?php

namespace TwoDotsTwice\CVWarehouse\Job;

class Urls
{
    /**
     * @var Url
     */
    private $applicationBranded;

    public function __construct(
        Url $applicationBranded
    ) {
        $this->applicationBranded = $applicationBranded;
    }

    /**
     * @return Url
     */
    public function getApplicationBranded()
    {
        return $this->applicationBranded;
    }
}
