<?php

namespace TwoDotsTwice\CVWarehouse;

use TwoDotsTwice\CVWarehouse\Job\Description;
use TwoDotsTwice\CVWarehouse\Job\Name;
use TwoDotsTwice\CVWarehouse\Job\Id;

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
     * Job constructor.
     * @param Id $id
     * @param Name $name
     * @param Description $description
     */
    public function __construct(Id $id, Name $name, Description $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
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
}
