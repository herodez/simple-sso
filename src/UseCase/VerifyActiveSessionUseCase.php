<?php

namespace Optime\SimpleSso\UseCase;

use Optime\SimpleSso\OneTimePassword\OneTimePasswordRepositoryInterface;
use Optime\SimpleSso\Security\PublicPasswordChecker;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class VerifyActiveSessionUseCase
{
    /**
     * @var OneTimePasswordRepositoryInterface
     */
    private $otpRepository;
    /**
     * @var PublicPasswordChecker
     */
    private $passwordChecker;

    /**
     * @param OneTimePasswordRepositoryInterface $otpRepository
     * @param PublicPasswordChecker $passwordChecker
     */
    public function __construct(
        OneTimePasswordRepositoryInterface $otpRepository,
        PublicPasswordChecker $passwordChecker
    ) {
        $this->otpRepository = $otpRepository;
        $this->passwordChecker = $passwordChecker;
    }

    /**
     * @param string $otp
     * @param string $created
     * @param string $publicPassword
     * @return boolean
     */
    public function handle($otp, $created, $publicPassword)
    {
        $result = true;

        if (!$otp || !$created || !$publicPassword) {
            throw new \InvalidArgumentException('Invalid Parameters');
        }

        $otp = $this->otpRepository->findUsedByOtp($otp);

        if (!$otp) {
            $result = false;
        }

        $this->passwordChecker->check($otp, $created, $publicPassword);

        return $result;
    }
}