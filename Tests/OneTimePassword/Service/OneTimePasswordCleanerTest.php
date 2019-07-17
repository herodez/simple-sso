<?php

namespace Optime\Bundle\SimpleSsoServerBundle\Tests;

use Optime\SimpleSso\OneTimePassword\OneTimePasswordRepositoryInterface;
use Optime\SimpleSso\OneTimePassword\Service\OneTimePasswordCleaner;
use Optime\SimpleSso\UnitOfWorkInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class OneTimePasswordCleanerTest extends TestCase
{
    /**
     * @var OneTimePasswordCleaner
     */
    private $cleaner;

    /**
     * @var OneTimePasswordRepositoryInterface
     */
    private $repository;

    public function setUp()
    {
        $this->repository = $this->prophesize(OneTimePasswordRepositoryInterface::class);

        $this->cleaner = new OneTimePasswordCleaner(
            $this->repository->reveal()
        );
    }

    public function test()
    {
        $this->repository->removeByUsername('username')
            ->shouldBeCalled();

        $this->cleaner->clearByUsername('username');
    }
}
