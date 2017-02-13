<?php

namespace TwoDotsTwice\CVWarehouse\Job;

use Webmozart\Assert\Assert;

class Description
{
    private $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        Assert::string($value);
        Assert::notEmpty($value);

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
