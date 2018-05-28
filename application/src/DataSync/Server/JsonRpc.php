<?php

namespace DataSync\Server;

/**
 * Class JsonRpc
 *
 * @package DataSync\Server
 */
class JsonRpc implements ServerInterface
{
    /**
     * @var \JsonRPC\Server
     */
    protected $server;

    /**
     * JsonRpc constructor.
     *
     * @param $server
     */
    public function __construct($server)
    {
        $this->server = $server;
    }

    /**
     * Init the Server.
     *
     * @param null $options
     *
     * @return bool
     */
    public function init($options = null) : bool
    {
        $api = $options['api'];

        $procedureHandler = $this->server->getProcedureHandler();
        $procedureHandler->withObject($api);

        return true;
    }

    /**
     * Run the server.
     *
     * @return string
     */
    public function run()
    {
        return $this->server->execute();
    }
}