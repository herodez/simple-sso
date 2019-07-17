<?php

namespace Optime\SimpleSso\Application;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class Application implements ApplicationInterface
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;

    /**
     * Application constructor.
     * @param string $name
     * @param string $username
     * @param string $password
     */
    public function __construct($name, $username, $password)
    {
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}