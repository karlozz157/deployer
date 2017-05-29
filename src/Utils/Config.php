<?php

namespace Deployer\Utils;

class Config
{
    /**
     * @const string
     */
    const CONFIG_FILENAME = 'params.json';

    /**
     * @param string $param
     *
     * @return mixed
     */
    public static function getParam($param)
    {
        $config = static::getConfigFile();

        if (!isset($config[$param])) {
            throw new \Exception(sprintf('El parámetro "%s" no existe!', $param));
        }

        return $config[$param];
    }

    /**
     * @return array
     */
    protected static function getConfigFile()
    {
        $configFilename = sprintf('%s/../../config/%s', __DIR__, self::CONFIG_FILENAME);

        if (!file_exists($configFilename)) {
            throw new \Exception(sprintf('Por favor, configura tu archivo %s', $configFilename));
        }

        $content = file_get_contents($configFilename);
    
        return json_decode($content, true);
    }
}
