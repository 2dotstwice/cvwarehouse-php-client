<?php

namespace TwoDotsTwice\CVWarehouse\Job;

use Webmozart\Assert\Assert;

class Id
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        Assert::string($value);
        Assert::notEmpty($value);
        Assert::regex($value, '/^[^\s].*[^\s]$/', 'Id should not have leading or trailing whitespace');

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
