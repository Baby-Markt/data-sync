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
     * Get the fields of the given Table.
     *
     * @param $table
     *
     * @return array
     */
    public function getFields($table);

    /**
     * Check if the table has the given Field.
     *
     * @param $table
     * @param $fieldName
     *
     * @return mixed
     */
    public function hasField($table, $fieldName);

    /**
     * Check if the given Field of the given Table has changed.
     *
     * @param $table
     * @param $field
     *
     * @return mixed
     */
    public function hasFieldChanged($table, $field);

    /**
     * Add given Field of the given Table after Field.
     *
     * @param $table
     * @param $field
     * @param null $previousField
     *
     * @return mixed
     */
    public function addField($table, $field, $previousField = null);

    /**
     * Modify the given Field of the given Table.
     *
     * @param $table
     * @param $field
     *
     * @return mixed
     */
    public function modifyField($table, $field);

    /**
     * Drop remaining Fields of the given Table not in given Fields list.
     *
     * @param $table
     * @param $fields
     *
     * @return mixed
     */
    public function dropFields($table, $fields);

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