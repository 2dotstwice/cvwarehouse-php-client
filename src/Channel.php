<?php
/**
 * @file
 */

namespace TwoDotsTwice\CVWarehouse;

class Channel
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Channel
     */
    public static function ownWebsite()
    {
        return new self('Own_website');
    }
}
