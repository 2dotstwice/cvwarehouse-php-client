<?php

namespace TwoDotsTwice\CVWarehouse\XML;

use TwoDotsTwice\CVWarehouse\JobCollection;

interface Parser
{
    /**
     * @return Format
     */
    public function format();

    /**
     * @param string $xml
     * @return JobCollection
     */
    public function parse($xml);
}
