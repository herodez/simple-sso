<?php
    
namespace Optime\SimpleSso\OneTimePassword;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
interface OneTimePasswordRepositoryInterface
{
    /**
     * @param string $otp
     * @return OneTimePassword
     */
    public function findByOtp($otp);

    /**
     * @param string $otp
     * @return OneTimePassword
     */
    public function findNotUsedByOtp($otp);

    /**
     * @param string $otp
     * @return OneTimePassword
     */
    public function findUsedByOtp($otp);

    /**
     * @param OneTimePassword $oneTimePassword
     * @param bool|true $flush
     */
    public function save(OneTimePassword $oneTimePassword, $flush = true);

    /**
     * @param string $username
     * @param bool|true $flush
     */
    public function removeByUsername($username, $flush = true);
}
