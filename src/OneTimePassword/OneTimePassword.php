<?php

namespace Optime\SimpleSso\OneTimePassword;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class OneTimePassword
{
    /**
     * @var string
     */
    protected $otp;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $application;

    /**
     * @var string
     */
    protected $authData;

    /**
     * @var bool
     */
    protected $used = false;

    /**
     * OneTimePassword constructor.
     * @param string $otp
     * @param string $application
     * @param string $username
     * @param string $authData
     */
    public function __construct($otp, $application, $username, $authData)
    {
        $this->otp = $otp;
        $this->application = $application;
        $this->username = $username;
        $this->authData = $authData;
    }

    /**
     * @return string
     */
    public function getOtp()
    {
        return $this->otp;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @return string
     */
    public function getAuthData()
    {
        return $this->authData;
    }

    /**
     * @return boolean
     */
    public function isUsed()
    {
        return $this->used;
    }

    public function markAsUsed()
    {
        $this->used = true;

        return $this;
    }

    public function __toString()
    {
        return $this->getOtp();
    }
}