<?php

class pdo_mssql
{
    public ?PDO $conn = null;
    private string $hostname = '.\\SQLSERVER';
    private string $dbname = 'movies';
    private string $user = 'applicatie';
    private string $password = 'testpassword!Hallo-1244!';

    public function __construct()
    {
        $this->connect();
    }

    public function __destruct()
    {
        $this->close();
    }

    public function connect(): void
    {
        try {
            $this->conn = new PDO("sqlsrv:Server=$this->hostname;Database=$this->dbname;ConnectionPooling=0;TrustServerCertificate=1", $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->close();
        }
    }

    public function close(): void
    {
        $this->conn = null;
    }

    public function selectAll(Entity $entity)
    {
        $tablename = get_class($entity);
        $properties = $entity->createPropertyList();
        $sql = "SELECT $properties FROM $tablename";
        $this->conn ?? $this->connect();
        $query = $this->conn->prepare($sql);
        $query->execute();

        $result = $query->fetchAll();
        return $result;
    }

    public function insert(Entity $entity)
    {
        $tablename = get_class($entity);
        $properties = $entity->createPropertyList();
        $placeholders = $entity->createPlaceholders();
        $values = $entity->getValuesOutOfEntity();
        $sql = "INSERT INTO $tablename ($properties) VALUES ($placeholders)";
        $this->conn ?? $this->connect();
        $isSuccesfull = $this->conn->prepare($sql)->execute($values);
        return $isSuccesfull;
    }

    public function update(Entity $entity, string $whereClause)
    {
        $tablename = get_class($entity);
        $setString = $entity->createSetString();
        $sql = "UPDATE $tablename SET $setString WHERE $whereClause";
        $this->conn ?? $this->connect();
        $query = $this->conn->prepare($sql);
        return $query->execute();
    }
}