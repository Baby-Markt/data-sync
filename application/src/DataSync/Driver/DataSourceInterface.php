<?php

namespace DataSync\Driver;

/**
 * Interface DataSourceInterface
 *
 * @package DataSync\Driver
 */
interface DataSourceInterface
{
    /**
     * Get all available Tables.
     *
     * @return array
     */
    public function getTables();

    /**
     * Get the Create Table Query for the given Table.
     *
     * @param string $table
     *
     * @return string
     */
    public function getCreateTableQuery($table);

    /**
     * Get the fields of the given Table.
     *
     * @param $table
     *
     * @return array
     */
    public function getFields($table);

    /**
     * Get Entries Count for the given Table.
     *
     * @param string $table
     *
     * @return int
     */
    public function getEntriesCountForTable($table);

    /**
     * Get Entries for the given Table.
     *
     * @param string $table
     * @param string $fields
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function getEntries($table, $fields = '*', $limit = 10, $offset = 0);

    /**
     * Get Entry for the given Table.
     *
     * @param string $table
     * @param string $fields
     * @param int $id
     * @param string $idName
     * @param string $idType
     *
     * @return array
     */
    public function getEntry($table, $fields = '*', $id = 1, $idName = 'id', $idType = 'int');
}