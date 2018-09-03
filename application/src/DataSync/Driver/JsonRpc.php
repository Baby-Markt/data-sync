<?php

namespace DataSync\Driver;

/**
 * Class JsonRpc
 *
 * @package DataSync\Driver
 */
class JsonRpc implements DataDestinationInterface, DataSourceInterface
{
    /**
     * @var \JsonRPC\Client
     */
    protected $client;

    /**
     * JsonRpc constructor.
     *
     * @param \JsonRPC\Client $client
     */
    public function __construct(\JsonRPC\Client $client)
    {
        $this->client = $client;
//        $this->client->getHttpClient()->withDebug();
    }

    /**
     * Is the Table available?
     *
     * @param string $table
     *
     * @return bool
     */
    public function hasTable($table)
    {
        return $this->client->hasTable($table);
    }

    /**
     * Create Table with the given Table Query.
     *
     * @param string $query
     *
     * @return void
     */
    public function createTable($query)
    {
        return $this->client->createTable($query);
    }

    /**
     * Get the fields of the given Table.
     *
     * @param $table
     *
     * @return array
     */
    public function getFields($table)
    {
        return $this->client->getFields($table);
    }

    /**
     * Check if the table has the given Field.
     *
     * @param $table
     * @param $fieldName
     *
     * @return mixed
     */
    public function hasField($table, $fieldName)
    {
        return $this->client->hasField($table, $fieldName);
    }

    /**
     * Check if the given Field of the given Table has changed.
     *
     * @param $table
     * @param $field
     *
     * @return mixed
     */
    public function hasFieldChanged($table, $field)
    {
        return $this->client->hasFieldChanged($table, $field);
    }

    /**
     * Add given Field of the given Table after Field.
     *
     * @param $table
     * @param $field
     * @param null $previousField
     *
     * @return mixed
     */
    public function addField($table, $field, $previousField = null)
    {
        return $this->client->addField($table, $field, $previousField);
    }

    /**
     * Modify the given Field of the given Table.
     *
     * @param $table
     * @param $field
     *
     * @return mixed
     */
    public function modifyField($table, $field)
    {
        return $this->client->modifyField($table, $field);
    }

    /**
     * Drop remaining Fields of the given Table not in given Fields list.
     *
     * @param $table
     * @param $fields
     *
     * @return mixed
     */
    public function dropFields($table, $fields)
    {
        return $this->client->dropFields($table, $fields);
    }

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
    public function hasEntry($table, $id, $idName = 'id', $idType = 'int')
    {
        return $this->client->hasEntry($table, $id, $idName, $idType);
    }

    /**
     * Insert an Entry into the Table.
     *
     * @param string $table
     * @param array $entry
     *
     * @return void
     */
    public function insertEntry($table, $entry)
    {
        return $this->client->insertEntry($table, $entry);
    }

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
    public function hasEntryChanged($table, $entry, $idName = 'id', $idType = 'int')
    {
        return $this->client->hasEntryChanged($table, $entry, $idName, $idType);
    }

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
    public function updateEntry($table, $entry, $idName = 'id', $idType = 'int')
    {
        return $this->client->updateEntry($table, $entry, $idName, $idType);
    }

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
    public function deleteEntries($table, $entryIds, $idName = 'id', $idType = 'int')
    {
        return $this->client->deleteEntries($table, $entryIds, $idName, $idType);
    }

    /**
     * Get all available Tables.
     *
     * @return array
     */
    public function getTables()
    {
        return $this->client->getTables();
    }

    /**
     * Create Table with the given Table Query.
     *
     * @param string $table
     *
     * @return string
     */
    public function getCreateTableQuery($table)
    {
        return $this->client->getCreateTableQuery($table);
    }

    /**
     * Get Entries Count for the given Table.
     *
     * @param string $table
     *
     * @return int
     */
    public function getEntriesCountForTable($table)
    {
        return $this->client->getEntriesCountForTable($table);
    }

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
    public function getEntries($table, $fields = '*', $limit = 10, $offset = 0)
    {
        return $this->client->getEntries($table, $fields, $limit, $offset);
    }

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
    public function getEntry($table, $fields = '*', $id = 1, $idName = 'id', $idType = 'int')
    {
        return $this->client->getEntry($table, $fields, $id, $idName, $idType);
    }
}