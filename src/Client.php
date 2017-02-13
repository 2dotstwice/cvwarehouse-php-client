<?php

namespace TwoDotsTwice\CVWarehouse;

interface Client
{
    /**
     * @param Channel $channel
     * @param Language|null $language
     * @return JobCollection
     */
    public function jobs(Channel $channel, Language $language = null);
}
