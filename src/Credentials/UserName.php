<?php

namespace TwoDotsTwice\CVWarehouse\Credentials;

use Webmozart\Assert\Assert;

class UserName
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
        Assert::regex($value, '/^[^\s].*[^\s]$/', 'UserName should not have leading or trailing whitespace');

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
