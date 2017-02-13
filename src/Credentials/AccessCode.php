<?php
/**
 * @file
 */

namespace TwoDotsTwice\CVWarehouse\Credentials;

use Webmozart\Assert\Assert;

class AccessCode
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

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
