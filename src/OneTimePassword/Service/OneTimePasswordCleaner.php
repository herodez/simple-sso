<?php

namespace Optime\SimpleSso\OneTimePassword\Service;

use Optime\SimpleSso\OneTimePassword\OneTimePasswordRepositoryInterface;

/**
 * Esta clase se encarga de eliminar los registros que identifican
 * a un usuario como logueado para conocimiento de los modulos
 * que se conectan por SSO.
 *
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class OneTimePasswordCleaner
{
    /**
     * @var OneTimePasswordRepositoryInterface
     */
    private $oneTimePasswordRepository;

    /**
     * @param OneTimePasswordRepositoryInterface $oneTimePasswordRepository
     */
    public function __construct(OneTimePasswordRepositoryInterface $oneTimePasswordRepository)
    {
        $this->oneTimePasswordRepository = $oneTimePasswordRepository;
    }

    public function clearByUsername($username)
    {
        $this->oneTimePasswordRepository->removeByUsername($username);
    }
}