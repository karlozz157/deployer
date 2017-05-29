<?php

namespace Deployer\Storage;

use Deployer\Entity\File;
use Deployer\Utils\Config;

class StorageSftp implements StorageInterface
{
    /**
     * @const string
     */
    const SFTP_PARAM = 'sftp';

    /**
     * @var mixed $connection
     */
    protected $connection;

    /**
     * @var array $params
     */
    protected $params;

    public function __construct()
    {
        $this->params = Config::getParam(self::SFTP_PARAM);
        $this->connect();
    }

    public function __destruct()
    {
        $this->close();
    }

    /**
     * @param File $file
     */
    public function upload(File $file)
    {
        $directory = substr($file->getRemoteName(), 0, strrpos($file->getRemoteName(), '/'));
        @ssh2_exec($this->connection, sprintf('mkdir -p %s', $directory));

        if (!ssh2_scp_send($this->connection, $file->getName(), $file->getRemoteName())) {
            throw new \Exception(sprintf('No se pudo subir el archivo %s a %s en el servidor!', $file->getName(), $file->getRemoteName()));
        }
    }

    protected function connect()
    {
        if (!$this->connection = ssh2_connect($this->params['hostname'])) {
            throw new \Exception('No se pudo realizar la conexión con el servidor!');
            
        }

        if (!ssh2_auth_password($this->connection, $this->params['username'], $this->params['password'])) {
            throw new \Exception('No se pudo autenticar con las credenciales en el servidor!');
        }
    }

    protected function close()
    {
        $this->connection = null;
    }
}
