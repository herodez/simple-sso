<?php
/*
 * This file is part of the Manuel Aguirre Project.
 *
 * (c) Manuel Aguirre <programador.manuel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Optime\SimpleSso\UseCase;

use Optime\SimpleSso\OneTimePassword\Service\OneTimePasswordGenerator;
use Optime\SimpleSso\Security\AuthDataResolverInterface;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class CreateLoginOtpUseCase
{
    /**
     * @var OneTimePasswordGenerator
     */
    private $otpGenerator;
    /**
     * @var AuthDataResolverInterface
     */
    private $authDataResolver;
	
	/**
	 * CreateLoginOtpUseCase constructor.
	 * @param OneTimePasswordGenerator $otpGenerator
	 * @param AuthDataResolverInterface $authDataResolver
	 */
    public function __construct(OneTimePasswordGenerator $otpGenerator, AuthDataResolverInterface $authDataResolver)
    {
        $this->otpGenerator = $otpGenerator;
        $this->authDataResolver = $authDataResolver;
    }

    public function handle($appName, $targetPath)
    {
        $otp = $this->otpGenerator->generateOtp(
            $appName,
            $this->authDataResolver->getUsername(),
            serialize($this->authDataResolver->getData())
        );
        
        $targerPathAndQueries = explode('?', $targetPath);
        
        
        if(count($targerPathAndQueries) === 2){
            $targer = $targerPathAndQueries[0];
            $queries = $targerPathAndQueries[1] . '&_sso_otp='.urlencode($otp);
            $targetPath = $targer . '?' . $queries;
        }
        else{
            $targetPath .= '?_sso_otp='.urlencode($otp);
        }
        
        return $targetPath;
    }
}