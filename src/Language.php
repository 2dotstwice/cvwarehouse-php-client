<?php

namespace TwoDotsTwice\CVWarehouse;

use Webmozart\Assert\Assert;

class Language
{
    /**
     * @var string
     */
    private $isoCode;

    /**
     * @param string $isoCode
     */
    public function __construct($isoCode)
    {
        Assert::regex($isoCode, '/[a-z]{2}-[A-Z]{2}/');

        $this->isoCode = $isoCode;
    }

    public function __toString()
    {
        return $this->isoCode;
    }

    /**
     * @return Language
     */
    public static function dutchBelgium()
    {
        return new self('nl-BE');
    }
}
