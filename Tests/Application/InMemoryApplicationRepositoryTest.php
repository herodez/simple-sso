<?php

namespace Optime\Bundle\SimpleSsoServerBundle\Tests\Application;

use Optime\SimpleSso\Application\ApplicationInterface;
use Optime\SimpleSso\Application\ApplicationRepositoryInterface;
use Optime\SimpleSso\Application\InMemoryApplicationRepository;
use PHPUnit\Framework\TestCase;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class InMemoryApplicationRepositoryTest extends TestCase
{
    /**
     * @var DefaultApplicationRepository
     */
    private $repository;

    private $applications = [
        'app1' => ['name' => "app1", 'username' => 'username1', 'password' => 'pass1'],
    ];

    public function setUp()
    {
        $this->repository = new InMemoryApplicationRepository($this->applications);
    }

    public function testGetExistentApplication()
    {
        $data = $this->repository->findByName('app1');

        $this->assertInstanceOf(ApplicationInterface::class, $data);
        $this->assertSame($this->applications['app1']['name'], $data->getName());
        $this->assertSame($this->applications['app1']['username'], $data->getUsername());
        $this->assertSame($this->applications['app1']['password'], $data->getPassword());
    }

    public function testGetInvalidApplication()
    {
        $this->setExpectedExceptionRegExp(\InvalidArgumentException::class, '/username/');

        $this->repository->findByName('abc-not-exists');
    }

    public function testInstance()
    {
        $this->assertInstanceOf(ApplicationRepositoryInterface::class, $this->repository);
    }
}
