<?php

namespace Optime\SimpleSso\Security;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
interface AuthDataResolverInterface
{
    public function getUsername();
    public function getData();
}