<?php

namespace DataSync\Action;

use DataSync\Driver\DataDestinationInterface;
use DataSync\Driver\DataSourceInterface;

/**
 * Interface ActionInterface
 *
 * @package DataSync\Action
 */
interface ActionInterface
{
    /**
     * Execute the Action.
     *
     * @param DataDestinationInterface $destination
     * @param DataSourceInterface $source
     *
     * @return bool
     */
    public function execute(DataDestinationInterface $destination, DataSourceInterface $source) : bool;
}