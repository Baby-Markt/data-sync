<?php

namespace DataSync\Server;

/**
 * Interface ServerInterface
 *
 * @package DataSync\Server
 */
interface ServerInterface
{
    /**
     * Initialize the Server.
     *
     * @param null|array $options
     *
     * @return bool
     */
    public function init($options = null) : bool;

    /**
     * Run the Server.
     *
     * @return mixed
     */
    public function run();
}