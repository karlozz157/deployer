<?php

namespace Deployer\Entity;

use Deployer\Utils\Config;

class File
{
    /**
     * @const string
     */
    const WORKPLACE_PARAM = 'workplace';

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return sprintf('%s/%s', Config::getParam(self::WORKPLACE_PARAM)['local'], $this->name);
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $filename = sprintf('%s/%s', Config::getParam(self::WORKPLACE_PARAM)['local'], $name);

        if (!file_exists($filename)) {
            throw new \Exception(sprintf('El archivo "%s" no existe!', $name));
        }

        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getRemoteName()
    {
        return sprintf('%s/%s', Config::getParam(self::WORKPLACE_PARAM)['remote'], $this->name);
    }
}
