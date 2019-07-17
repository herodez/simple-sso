<?php

namespace Optime\SimpleSso\Application;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
interface ApplicationRepositoryInterface
{
    /**
     * @param string $application
     * @return ApplicationInterface
     *
     * @throws \InvalidArgumentException si no encuentra la aplicaci�n por username
     */
    public function findByName($application);
}