<?php

namespace Optime\Bundle\SimpleSsoServerBundle\Tests;

use Optime\SimpleSso\OneTimePassword\OneTimePassword;
use Optime\SimpleSso\OneTimePassword\OneTimePasswordFactoryInterface;
use Optime\SimpleSso\OneTimePassword\OneTimePasswordRepositoryInterface;
use Optime\SimpleSso\OneTimePassword\Service\OneTimePasswordGenerator;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class OneTimePasswordGeneratorTest extends TestCase
{
    /**
     * @var OneTimePasswordGenerator
     */
    private $otpGenerator;
    private $securityData;

    /**
     * @var ObjectProphecy|OneTimePasswordRepositoryInterface
     */
    private $otpRepository;

    public function setUp()
    {
        $this->otpRepository = $this->prophesize(OneTimePasswordRepositoryInterface::class);
        $this->otpRepository->findByOtp(Argument::any())->willReturn(null);
        $this->otpRepository->save(Argument::any())->willReturn(null);

        $oneTimePasswordFactory = $this->prophesize(OneTimePasswordFactoryInterface::class);
        $oneTimePasswordFactory->create(Argument::cetera())->will(function ($args) {
            return new OneTimePassword(
                $args[0],
                $args[1],
                $args[2],
                $args[3]
            );
        });

        $this->otpGenerator = new OneTimePasswordGenerator(
            $this->otpRepository->reveal(),
            $oneTimePasswordFactory->reveal()
        );

        $this->securityData = ['username' => 'username_test'];
    }

    public function testReturnInstanceOfOTP()
    {
        $otp = $this->otpGenerator->generateOtp('application', 'username', serialize($this->securityData));

        $this->assertInstanceOf(OneTimePassword::class, $otp);
    }

    public function testOTPApplication()
    {
        $otp = $this->otpGenerator->generateOtp('application', 'username', serialize($this->securityData));

        $this->assertEquals('application', $otp->getApplication());
    }


    public function testOTPUsername()
    {
        $otp = $this->otpGenerator->generateOtp('application', 'username', serialize($this->securityData));

        $this->assertEquals('username', $otp->getUsername());
    }

    public function testOTPNotUsed()
    {
        $otp = $this->otpGenerator->generateOtp('application', 'username', serialize($this->securityData));

        $this->assertFalse($otp->isUsed());
    }

    public function testAuthData()
    {
        $otp = $this->otpGenerator->generateOtp('application', 'username', $data = serialize($this->securityData));

        $this->assertEquals($data, $otp->getAuthData());
    }

    public function testOtpMustBePersisted()
    {
        $otp = $this->otpGenerator->generateOtp('application', 'username', $data = serialize($this->securityData));

        $this->otpRepository->save($otp)->shouldHaveBeenCalled();
    }

    /**
     * Validamos que si la clave existe en el sistema, se genere otra hasta que se cree una que no exista.
     */
    public function testOtpValueExists()
    {
        $calls = 3;
        $counter = 1;
        $otpMock = $this->prophesize(OneTimePassword::class);

        $findReturn = function () use ($calls, &$counter, $otpMock) {
            if ($counter++ >= $calls) {
                return null;
            }

            return $otpMock->reveal();
        };

        $this->otpRepository->findByOtp(Argument::any())->will($findReturn);

        $otp = $this->otpGenerator->generateOtp('application', 'username', $data = serialize($this->securityData));

        $this->otpRepository->findByOtp(Argument::any())->shouldHaveBeenCalledTimes($calls);
    }
}
