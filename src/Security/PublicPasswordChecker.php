<?php

namespace Optime\SimpleSso\Security;

use Optime\SimpleSso\Application\ApplicationRepositoryInterface;
use Optime\SimpleSso\OneTimePassword\OneTimePassword;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class PublicPasswordChecker
{
    /**
     * @var ApplicationRepositoryInterface
     */
    private $applicationRepository;

    /**
     * PublicPasswordChecker constructor.
     * @param ApplicationRepositoryInterface $applicationRepository
     */
    public function __construct(ApplicationRepositoryInterface $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    /**
     * @param OneTimePassword $oneTimePassword
     * @param $created
     * @param $publicPassword
     *
     * @throws \InvalidArgumentException
     */
    public function check(OneTimePassword $oneTimePassword, $created, $publicPassword)
    {
        $application = $this->applicationRepository->findByName($oneTimePassword->getApplication());
        $hash = base64_encode(sha1($oneTimePassword->getOtp().$created.$application->getPassword()));

        if ($publicPassword != $hash) {
            throw new \InvalidArgumentException('Invalid Credentials');
        }
    }
}