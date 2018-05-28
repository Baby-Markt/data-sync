<?php

namespace DataSync\Driver;

/**
 * Class MySql
 *
 * @package DataSync\Driver
 */
class MySql implements DataDestinationInterface, DataSourceInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * MySql constructor.
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function hasTable($table)
    {
        $query  = sprintf('SHOW TABLES LIKE \'%s\'', $table);

        $stmt   = $this->pdo->query($query);
        $result = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        return count($result) == 1;
    }

    public function createTable($query)
    {
//        $query  = $this->client->getCreateTableQuery($table);

        $stmt  = $this->pdo->query($query);
        $result = $stmt->execute();

        return $result;
    }

    public function hasEntry($table, $id, $idName = 'id', $idType = 'int')
    {
        $query  = sprintf('SELECT %s FROM %s WHERE %s = \'%s\'', $idName, $table, $idName, $id);

        $stmt  = $this->pdo->query($query);
        $result = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        return count($result) == 1;
    }

    public function insertEntry($table, $entry)
    {
        $query      = $this->getInsertStatement($table, $entry);
        $attributes = $this->getAttributesCount($entry);

        foreach ($entry as $key => $value) {
            $keys[]   = $key;
            $values[] = $value;
        }

        $stmt = $this->pdo->prepare($query);

        for ($i = 0; $i < $attributes; $i++) {
            $stmt->bindParam(':' . $keys[$i], $values[$i]);
        }

        $result = $stmt->execute();

        return $result;
    }

    public function hasEntryChanged($table, $entry, $idName = 'id', $idType = 'int')
    {
        $query = sprintf('SELECT * FROM %s WHERE %s = \'%s\'', $table, $idName, $entry[$idName]);

        $stmt = $this->pdo->query($query);
        $dbEntry = $stmt->fetch(\PDO::FETCH_ASSOC);

        foreach ($dbEntry as $key => $value) {
            if ($entry[$key] != $value) {
                return true;
            }
        }

        return false;
    }

    public function updateEntry($table, $entry, $idName = 'id', $idType = 'int')
    {
        $set = '';

        $first = true;
        foreach ($entry as $key => $value) {

            if (!$first) {
                $set .= ', ';
            }

            if (is_null($value)) {
                $set .= sprintf('%s = NULL', $key);
            }
            else if (is_int($value)) {
                $set .= sprintf('%s = %u', $key, $value);
            }
            else if (is_float($value)) {
                $set .= sprintf('%s = %f', $key, $value);
            }
            else {
                $set .= sprintf('%s = "%s"', $key, $value);
            }

            if ($first) {
                $first = false;
            }
        }

        $query = sprintf('UPDATE %s SET %s WHERE %s = \'%s\'', $table, $set, $idName, $entry[$idName]);

        $stmt   = $this->pdo->query($query);
        $result = $stmt->execute();

        return $result;
    }

    public function deleteEntries($table, $entryIds, $idName = 'id', $idType = 'int')
    {
        foreach ($entryIds as $key => $value) {
            $entryIds[$key] = "'" . $value . "'";
        }

        $entryIdsString = implode(',', $entryIds);

        $query = sprintf('DELETE FROM %s WHERE %s NOT IN(%s)', $table, $idName, $entryIdsString);

        $stmt   = $this->pdo->query($query);
        $result = $stmt->execute();

        return $result;
    }

    protected function getInsertStatement($syncTable, $entry)
    {
        $sql = '';

        foreach ($entry as $key => $value) {
            $keys[] = $key;
        }

        $attributes = count($keys);

        $keyString = '';
        $valueString = '';

        for ($i = 0; $i < $attributes; $i++) {
            if ($i > 0) {
                $keyString .= ', ';
                $valueString .= ', ';
            }
            $keyString .= '' . $keys[$i];
            $valueString .= ':' . $keys[$i];
        }

        $sql = 'INSERT INTO ' . $syncTable . ' (' . $keyString . ' ) VALUES (' . $valueString . ')';

        return $sql;
    }

    protected function getAttributesCount($entry)
    {
        $attributes = count($entry);

        return $attributes;
    }

    public function getTables()
    {
        $stmt   = $this->pdo->query('SHOW TABLES');
        $tables = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        sort($tables);

        return $tables;
    }

    public function getCreateTableQuery($table)
    {
        $query = sprintf('SHOW CREATE TABLE %s', $table);

        $stmt   = $this->pdo->query($query);
        $result = $stmt->fetchAll(\PDO::FETCH_NUM);

        return $result[0][1];
    }

    public function getEntriesCountForTable($table)
    {
        $query = sprintf('SELECT COUNT(*) FROM %s', $table);

        $stmt   = $this->pdo->query($query);
        $result = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        return $result[0];
    }

    public function getEntries($table, $fields = '*', $limit = 10, $offset = 0)
    {
        $limit  = (int)$limit;
        $offset = (int)$offset;

        $query = sprintf('SELECT %s FROM %s', $fields, $table);

        if ($limit) {
            $query = sprintf('%s LIMIT %u OFFSET %u', $query, $limit, $offset);
        }

        $stmt   = $this->pdo->query($query);

        $result = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }

        return $result;
    }

    public function getEntry($table, $fields = '*', $id = 1, $idName = 'id', $idType = 'int')
    {
        $id = $this->pdo->quote($id);

        $query = sprintf('SELECT %s FROM %s WHERE %s = %s', $fields, $table, $idName, $id);

        $stmt   = $this->pdo->query($query);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }
}