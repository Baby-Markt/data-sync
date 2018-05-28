<?php

namespace DataSync\Driver;

/**
 * Interface DataDestinationInterface
 *
 * @package DataSync\Driver
 */
interface DataDestinationInterface
{
    /**
     * Is the Table available?
     *
     * @param string $table
     *
     * @return bool
     */
    public function hasTable($table);

    /**
     * Create Table with the given Table Query.
     *
     * @param string $query
     *
     * @return void
     */
    public function createTable($query);

    /**
     * Has the Table an Entry with the given ID?
     *
     * @param string $table
     * @param mixed $id
     * @param string $idName
     * @param string $idType
     *
     * @return bool
     */
    public function hasEntry($table, $id, $idName = 'id', $idType = 'int');

    /**
     * Insert an Entry into the Table.
     *
     * @param string $table
     * @param array $entry
     *
     * @return void
     */
    public function insertEntry($table, $entry);

    /**
     * Has the given Entry in the Table changed?
     *
     * @param string $table
     * @param array $entry
     * @param string $idName
     * @param string $idType
     *
     * @return bool
     */
    public function hasEntryChanged($table, $entry, $idName = 'id', $idType = 'int');

    /**
     * Update the Entry of the given Table.
     *
     * @param string $table
     * @param array $entry
     * @param string $idName
     * @param string $idType
     *
     * @return void
     */
    public function updateEntry($table, $entry, $idName = 'id', $idType = 'int');

    /**
     * Delete Entries in the Table except the given Entry IDs.
     *
     * @param string $table
     * @param array $entryIds
     * @param string $idName
     * @param string $idType
     *
     * @return void
     */
    public function deleteEntries($table, $entryIds, $idName = 'id', $idType = 'int');
}