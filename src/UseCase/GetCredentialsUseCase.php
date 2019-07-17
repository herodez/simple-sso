<?php

namespace Optime\SimpleSso\UseCase;

use Optime\SimpleSso\OneTimePassword\OneTimePasswordRepositoryInterface;
use Optime\SimpleSso\Security\PublicPasswordChecker;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class GetCredentialsUseCase
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
     * @return string La data de autenticación almacenada en la BD
     */
    public function handle($otp, $created, $publicPassword)
    {
        if (!$otp or !$created or !$publicPassword) {
            throw new \InvalidArgumentException('Invalid Parameters');
        }

        $otp = $this->otpRepository->findNotUsedByOtp($otp);

        if (!$otp) {
            throw new \InvalidArgumentException('Invalid password');
        }

        $otp->markAsUsed(true);
        $this->otpRepository->save($otp);

        $this->passwordChecker->check($otp, $created, $publicPassword);

        return $otp->getAuthData();
    }
}