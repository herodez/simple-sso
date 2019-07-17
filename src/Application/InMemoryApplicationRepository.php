<?php

namespace Optime\SimpleSso\Application;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class InMemoryApplicationRepository implements ApplicationRepositoryInterface
{
    /**
     * @var array
     */
    private $applications;

    /**
     * DefaultApplicationRepository constructor.
     * @param array $applications
     */
    public function __construct(array $applications)
    {
        $this->applications = $applications;
    }

    public function findByName($application)
    {
        $application = (string)$application;

        if (!isset($this->applications[$application])) {
            throw new \InvalidArgumentException(sprintf('Application with username "%s" not found', $application));
        }

        $data = $this->applications[$application];

        return new Application($data['name'], $data['username'], $data['password']);
    }
}