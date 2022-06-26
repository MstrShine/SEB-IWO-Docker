<?php
require_once '../php/data/connection.php';
require_once '../models/Movie.php';

function fetchMovieData($filmId, &$movie, &$cast, &$directors)
{
    $pdo = new pdo_mssql();

    $movie = new Movie();
    $movie = $pdo->fetchMovieById($filmId);
    $cast = $pdo->fetchCastByMovieId($filmId);
    $directors = $pdo->fetchDirectorsByMovieId($filmId);
}