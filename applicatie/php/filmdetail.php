<?php
require_once '../php/connection.php';
require_once '../models/Movie.php';

function fetchMovieData($filmId, &$movie, &$cast, &$directors)
{
    $pdo = new pdo_mssql();

    $fetchArray = [':id' => $filmId];

    $movie = new Movie();
    $props = $movie->createPropertyList();
    $movieSql = "SELECT $props FROM Movie WHERE movie_id = :id";
    $stmt = $pdo->conn->prepare($movieSql);
    $stmt->execute($fetchArray);
    $movie = $stmt->fetch();

    unset($stmt);
    $castSql = "SELECT P.firstname as firstname, P.lastname as lastname, MC.role as role FROM Movie_Cast MC INNER JOIN Person P on P.person_id = MC.person_id WHERE movie_id = :id";
    $stmt = $pdo->conn->prepare($castSql);
    $stmt->execute($fetchArray);
    $cast = $stmt->fetchAll();

    unset($stmt);
    $directorSql = "SELECT P.firstname as firstname, P.lastname as lastname FROM Movie_Director MD INNER JOIN Person P on P.person_id = MD.person_id WHERE movie_id = :id";
    $stmt = $pdo->conn->prepare($directorSql);
    $stmt->execute($fetchArray);
    $directors = $stmt->fetchAll();
}