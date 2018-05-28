<?php

namespace DataSync\Command;

use DataSync\Action\ActionInterface;
use DataSync\Driver\DataDestinationInterface;
use DataSync\Driver\DataSourceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SyncCommand
 *
 * @package DataSync\Command
 */
class SyncCommand extends Command
{
    /**
     * @var DataSync
     */
    protected $syncAction;

    /**
     * @var DataDestinationInterface
     */
    protected $destination;

    /**
     * @var DataSourceInterface
     */
    protected $source;

    /**
     * SyncCommand constructor.
     *
     * @param ActionInterface $syncAction
     * @param DataDestinationInterface $destination
     * @param DataSourceInterface $source
     */
    public function __construct(ActionInterface $syncAction,
                                DataDestinationInterface $destination,
                                DataSourceInterface$source)
    {
        $this->syncAction  = $syncAction;
        $this->destination = $destination;
        $this->source      = $source;

        parent::__construct(null);
    }

    /**
     * Configure command.
     */
    protected function configure()
    {
        $this->setName('datasync:sync')
             ->setDescription('Sync local db with remote db.')
             ->setHelp('This command allows you to sync your locale db with the remote db.');
    }

    /**
     * Execute command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->syncAction->execute($this->destination, $this->source);
    }
}