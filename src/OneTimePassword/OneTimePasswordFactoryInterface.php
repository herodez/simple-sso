<?php

namespace Optime\SimpleSso\OneTimePassword;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
interface OneTimePasswordFactoryInterface
{
    /**
     * @param string $otp
     * @param string $application
     * @param string $username
     * @param string $authData
     */
    public function create($otp, $application, $username, $authData);
}