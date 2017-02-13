<?php

namespace TwoDotsTwice\CVWarehouse\XML;

use Webmozart\Assert\Assert;

class Format
{
    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $baseFormat;

    /**
     * @param string $baseFormat
     *   e.g. XML
     * @param string $version
     *   e.g. 1.10
     */
    public function __construct($baseFormat, $version)
    {
        Assert::string($baseFormat);
        Assert::notEmpty($baseFormat);

        Assert::string($version);
        Assert::regex($version, '/[1-9][0-9]*\.[0-9]+/');

        $this->baseFormat = $baseFormat;
        $this->version = $version;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->baseFormat . str_replace('.', '_', $this->version);
    }
}
