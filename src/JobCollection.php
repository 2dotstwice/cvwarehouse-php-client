<?php

namespace TwoDotsTwice\CVWarehouse;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class JobCollection implements IteratorAggregate, Countable
{
    /**
     * @var Job[]
     */
    private $jobs;

    /**
     * @param Job[] ...$jobs
     */
    public function __construct(Job ...$jobs)
    {
        $this->jobs = $jobs;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->jobs);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->jobs);
    }
}
