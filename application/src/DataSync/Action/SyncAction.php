<?php

namespace DataSync\Action;

use DataSync\Driver\DataDestinationInterface;
use DataSync\Driver\DataSourceInterface;

/**
 * Class SyncAction
 *
 * @package DataSync\Action
 */
class SyncAction implements ActionInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * SyncAction constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Log line.
     *
     * @param $line
     * @param string $newLine
     */
    protected function log($line, $newLine = "\r\n")
    {
        if ($this->options['log']) {
            echo $line, $newLine;
        }
    }

    /**
     * Get tables to sync.
     *
     * @return array
     */
    protected function getSyncTables()
    {
        $syncTablesString = $this->options['tables'];

        if (!$syncTablesString) {
            throw new DataSyncException('No sync tables configured. Please set datasync.client.options.tables in your app/config/parameters.yml file.');
        }

        $syncTables = explode(',', $syncTablesString);

        // clean entry strings
        foreach ($syncTables as $key => $syncTable) {
            $syncTable[$key] = trim($syncTable);
        }

        return $syncTables;
    }

    /**
     * Sync action.
     *
     * @param DataDestinationInterface $destination
     * @param DataSourceInterface $source
     *
     * @return bool
     */
    public function execute(DataDestinationInterface $destination, DataSourceInterface $source) : bool
    {
        $this->log('Sync started...');

        $syncTables = $this->getSyncTables();

        $this->log(sprintf('Tables: %s', implode(', ', $syncTables)));

        foreach ($syncTables as $syncTable) {

            $this->log(sprintf('Syncing Table %s', $syncTable));

            $syncTableEntriesCount = $source->getEntriesCountForTable($syncTable);

            $this->log(sprintf('Found %u Entries for %s', $syncTableEntriesCount, $syncTable));

            if ($syncTableEntriesCount == 0) {
                $this->log(sprintf('Skipping %s', $syncTable));
                // ignore empty tables
                continue;
            }

            $syncTableEntries = $source->getEntries($syncTable, $this->options['id'], false);

            $syncTableEntryIds = [];
            foreach ($syncTableEntries as $entry) {
                $idName              = $this->options['id'];
                $syncTableEntryIds[] = $entry[$idName];
            }

            if ($this->options['create_tables'] && !$destination->hasTable($syncTable)) {
                $query = $source->getCreateTableQuery($syncTable);
                $this->log(sprintf('Creating Table %s', $syncTable));
                $destination->createTable($query);
            }

            $blocksize = $this->options['blocksize'];
            for ($offset = 0; $offset < $syncTableEntriesCount; $offset += $blocksize) {

                $entries = $source->getEntries($syncTable, '*', $blocksize, $offset);

                foreach ($entries as $entry) {

                    $syncTableEntryId = $entry[$this->options['id']];
                    $this->log(sprintf('Syncing Entry %s', $syncTableEntryId), '');

                    if ($destination->hasEntry($syncTable, $syncTableEntryId, $this->options['id'])) {
                        // Update Entry if necessary
                        if ($destination->hasEntryChanged($syncTable, $entry, $this->options['id'])) {
                            $this->log(' => Update');
                            $destination->updateEntry($syncTable, $entry, $this->options['id']);
                        } else {
                            $this->log(' => Skip (No Changes)');
                        }
                    } else {
                        // Insert Entry
                        $this->log(' => Insert');
                        $destination->insertEntry($syncTable, $entry);
                    }
                }
            }

            if ($this->options['delete_entries']) {
                $this->log(sprintf('Deleting old local entries'));
                $destination->deleteEntries($syncTable, $syncTableEntryIds, $this->options['id']);
            }
        }

        $this->log('Sync finished.');

        return true;
    }
}