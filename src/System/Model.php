<?php

namespace App\System;

use App\System\Db as Db;

abstract class Model
{

    protected $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function __set(string $name, $value)
    {
        $className = $this->transformNameToClass($name);
        $this->$className = $value;
    }

    private function transformNameToClass(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    public static function findOneByColumn(string $columnName, $value): ?self
    {
        $db = Db::getInstance();
        $sql = "SELECT * FROM " . static::getNameTable() . " WHERE " . $columnName . " = :value LIMIT 1";
        $result = $db->query($sql, ['value' => $value], static::class);
        if ($result === []) {
            return null;
        }
        return $result[0];
    }

    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $entity = $db->query(
            "SELECT * FROM " . static::getNameTable() . " WHERE id=:id",
            ["id" => $id],
            static::class
        );
        return $entity ? $entity[0] : null;
    }

    abstract protected static function getNameTable(): string;

    public function save(): void
    {
        $mappedProperties = $this->mapData();
        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    public function insert(array $mappedProperties): void
    {
        $filteredProperties = array_filter($mappedProperties);

        $columns = [];
        $params = [];
        $values = [];
        foreach ($filteredProperties as $columnName => $value) {
            $columns[] = $columnName;
            $params[] = ':' . $columnName;
            $values[$columnName] = $value;
        }

        $columnsString = implode(', ', $columns);
        $paramsString = implode(', ', $params);

        $sql = "INSERT INTO " . static::getNameTable() . " (" . $columnsString . " ) VALUES (" . $paramsString . ")";
        $db = Db::getInstance();
        $db->query($sql, $values, static::class);
        $this->id = $db->getLastInsertId();
        //refresh($this);
    }

    public function update(array $mappedProperties): void
    {
        $params = [];
        $values = [];

        var_dump($this->authToken);
        foreach ($mappedProperties as $column => $value) {
            $params[] = $column . ' = :' . $column;
            $values[$column] = $value;
        }

        $paramsString = implode(', ', $params);

        $sql = "UPDATE " . static::getNameTable() . " SET " . $paramsString . " WHERE id = " . $this->id;
        $db = Db::getInstance();
        $db->query($sql, $values, static::class);
    }


    public function delete(): void
    {
        $db = Db::getInstance();
        $db->query(
            "DELETE FROM " . static::getNameTable() . " WHERE id = :id",
            ["id" => $this->id]
        );
        $this->id = null;
    }

    private function mapData(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();
        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsInDb = $this->transformNametoDb($propertyName);
            $mappedProperties[$propertyNameAsInDb] = $this->$propertyName;
        }
        return $mappedProperties;
    }

    private function transformNameToDb(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }
}