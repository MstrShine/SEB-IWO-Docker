<?php

class pdo_mssql
{
    public ?PDO $conn = null;
    private string $hostname = 'database_server';
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

    /**
     * Close connection with DB
     */
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
        $values = (array)$entity;
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

    function getMoviesByGenre(string $genreName)
    {
        $movie = new Movie();
        $propList = $movie->createPropertyList();
        $sql = "SELECT Movie.$propList FROM Movie_Genre INNER JOIN Movie on Movie.movie_id = Movie_Genre.movie_id WHERE genre_name = :name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":name" => $genreName]);

        return $stmt->fetchAll();
    }

    public function fetchAllMoviesWithGenre()
    {
        $sql = "SELECT 
            M.movie_id as movie_id,
            M.title as title, 
            M.description as description, 
            M.duration as duration, 
            M.cover_image as cover_image, 
            G.genre_name as genre,
            M.publication_year as year 
        FROM Movie_Genre MG 
            INNER JOIN Movie M on MG.movie_id = M.movie_id
            INNER JOIN Genre G on MG.genre_name = G.genre_name";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $movies = $stmt->fetchAll();

        return $movies;
    }

    public function fetchMoviesByFilters($genreSql, $titleSql, $genres, $title)
    {
        $sql = "SELECT 
            M.movie_id as movie_id,
            M.title as title, 
            M.description as description, 
            M.duration as duration, 
            M.cover_image as cover_image, 
            G.genre_name as genre 
        FROM Movie_Genre MG 
            INNER JOIN Movie M on MG.movie_id = M.movie_id
            INNER JOIN Genre G on MG.genre_name = G.genre_name 
        WHERE ";

        if ($genreSql != '' && $titleSql != '') {
            $sql .= $genreSql . ' AND ' . $titleSql;
        } else if ($genreSql != '') {
            $sql .= $genreSql;
        } else if ($titleSql != '') {
            $sql .= $titleSql;
        }

        $stmt = $this->conn->prepare($sql);
        $exArr = $genres;
        if ($titleSql != '') {
            $exArr[] = '%' . $title . '%';
            $stmt->execute($exArr);
        } else {
            $stmt->execute($exArr);
        }
        $movies = $stmt->fetchAll();

        return $movies;
    }

    public function checkMailCount($mail)
    {
        $sql = "SELECT COUNT(*) as 'count' FROM Customer where customer_mail_address = :mail";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':mail' => $mail]);
        $count = $stmt->fetch();

        return $count;
    }

    public function fetchLoginInfo($username)
    {
        $sql = "SELECT TOP(1) password, firstname, lastname FROM Customer WHERE user_name = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':username' => $username]);
        $res = $stmt->fetch();

        return $res;
    }

    public function fetchMovieById($id)
    {
        $movie = new Movie();
        $props = $movie->createPropertyList();
        $movieSql = "SELECT $props FROM Movie WHERE movie_id = :id";
        $stmt = $this->conn->prepare($movieSql);
        $stmt->execute([':id' => $id]);
        $movie = $stmt->fetch();

        return $movie;
    }

    public function fetchCastByMovieId($id)
    {
        $castSql = "SELECT P.firstname as firstname, P.lastname as lastname, MC.role as role FROM Movie_Cast MC INNER JOIN Person P on P.person_id = MC.person_id WHERE movie_id = :id";
        $stmt = $this->conn->prepare($castSql);
        $stmt->execute([':id' => $id]);
        $cast = $stmt->fetchAll();

        return $cast;
    }

    public function fetchDirectorsByMovieId($id)
    {
        $directorSql = "SELECT P.firstname as firstname, P.lastname as lastname FROM Movie_Director MD INNER JOIN Person P on P.person_id = MD.person_id WHERE movie_id = :id";
        $stmt = $this->conn->prepare($directorSql);
        $stmt->execute([':id' => $id]);
        $directors = $stmt->fetchAll();

        return $directors;
    }
}