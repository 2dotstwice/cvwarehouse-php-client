<?php

namespace TwoDotsTwice\CVWarehouse;

use TwoDotsTwice\CVWarehouse\Credentials\AccessCode;
use TwoDotsTwice\CVWarehouse\Credentials\UserName;

class Credentials
{
    /**
     * @var UserName
     */
    private $userName;

    /**
     * @var AccessCode
     */
    private $accessCode;

    /**
     * @param UserName $userName
     * @param AccessCode $accessCode
     */
    public function __construct(UserName $userName, AccessCode $accessCode)
    {
        $this->userName = $userName;
        $this->accessCode = $accessCode;
    }

    /**
     * @return UserName
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return AccessCode
     */
    public function getAccessCode()
    {
        return $this->accessCode;
    }
}
