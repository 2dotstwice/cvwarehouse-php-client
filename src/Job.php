<?php

namespace TwoDotsTwice\CVWarehouse;

use TwoDotsTwice\CVWarehouse\Job\Description;
use TwoDotsTwice\CVWarehouse\Job\Name;
use TwoDotsTwice\CVWarehouse\Job\Id;
use TwoDotsTwice\CVWarehouse\Job\Urls;

class Job
{
    /**
     * @var Name
     */
    private $name;

    /**
     * @var Description
     */
    private $description;

    /**
     * @var Id
     */
    private $id;

    /**
     * @var Urls
     */
    private $urls;

    /**
     * Job constructor.
     * @param Id $id
     * @param Name $name
     * @param Description $description
     * @param Urls $urls
     */
    public function __construct(
        Id $id,
        Name $name,
        Description $description,
        Urls $urls
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->urls = $urls;
    }

    /**
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Urls
     */
    public function getUrls()
    {
        return $this->urls;
    }
}
