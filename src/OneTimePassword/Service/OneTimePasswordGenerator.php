<?php

namespace Optime\SimpleSso\OneTimePassword\Service;

use Optime\SimpleSso\OneTimePassword\OneTimePassword;
use Optime\SimpleSso\OneTimePassword\OneTimePasswordFactoryInterface;
use Optime\SimpleSso\OneTimePassword\OneTimePasswordRepositoryInterface;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class OneTimePasswordGenerator
{
    /**
     * @var OneTimePasswordRepositoryInterface
     */
    private $oneTimePasswordRepository;
    /**
     * @var OneTimePasswordFactoryInterface
     */
    private $oneTimePasswordFactory;
	
	/**
	 * OneTimePasswordGenerator constructor.
	 * @param OneTimePasswordRepositoryInterface $oneTimePasswordRepository
	 * @param OneTimePasswordFactoryInterface $oneTimePasswordFactory
	 */
    public function __construct(
        OneTimePasswordRepositoryInterface $oneTimePasswordRepository,
        OneTimePasswordFactoryInterface $oneTimePasswordFactory
    ) {
        $this->oneTimePasswordRepository = $oneTimePasswordRepository;
        $this->oneTimePasswordFactory = $oneTimePasswordFactory;
    }
	
	/**
	 * @param string $applicationName
	 * @param string $username
	 * @param string $data
	 * @return OneTimePassword
	 * @throws \Exception
	 */
    public function generateOtp($applicationName, $username, $data)
    {
        do {
            $value = $this->generatePassword();
            $otp = $this->oneTimePasswordRepository->findByOtp($value);
            // mientras exista una en la bd, generamos otra clave.
        } while (!is_null($otp));

        $otp = $this->oneTimePasswordFactory->create($value, $applicationName, $username, (string)$data);

        $this->oneTimePasswordRepository->save($otp);

        return $otp;
    }

    private function generatePassword()
    {
        if (!function_exists('openssl_random_pseudo_bytes')) {
            throw new \Exception(
                'Could not produce a cryptographically strong random value. Please install/update the OpenSSL extension.'
            );
        }

        $bytes = openssl_random_pseudo_bytes(64, $strong);
        if (true === $strong && false !== $bytes) {
            return base64_encode($bytes);
        }

        return base64_encode(hash('sha512', uniqid(mt_rand(), true), true));
    }
}