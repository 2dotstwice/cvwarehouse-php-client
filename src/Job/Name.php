<?php

namespace TwoDotsTwice\CVWarehouse\Job;

use Webmozart\Assert\Assert;

class Name
{
    /**
     * @var string
     */
    private $value;

    /**
     * Title constructor.
     * @param $value
     */
    public function __construct($value)
    {
        Assert::string($value);
        Assert::notEmpty($value);
        Assert::regex($value, '/^[^\s].*[^\s]$/', 'Name should not have leading or trailing whitespace');

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
