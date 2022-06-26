<?php
require_once '../php/data/connection.php';
require_once '../models/Genre.php';
require_once '../models/Movie.php';

function fetchFilterData()
{
    $pdo = new pdo_mssql();
    $genres = $pdo->selectAll(new Genre());

    return $genres;
}

function fetchAllMoviesWithGenre()
{
    $pdo = new pdo_mssql();
    $movies = $pdo->fetchAllMoviesWithGenre();

    return $movies;
}

function searchMoviesByFilters($genreFilter, $titleFilter)
{
    $genreSql = '';
    if (count($genreFilter) > 0 || $genreFilter != null) {
        $genreSql = "MG.genre_name in (";
        $i = 1;
        foreach ($genreFilter as $genre) {
            if ($i == 1) {
                $genreSql .= "?";
                $i++;
            } else {
                $genreSql .= ", ?";
            }
        }
        $genreSql .= ')';
    }

    $titleSql = "";
    if ($titleFilter != '') {
        $titleSql .= "M.title like ?";
    }

    if ($titleSql == '' && $genreSql == '') {
        return;
    }

    $pdo = new pdo_mssql();

    $movies = $pdo->fetchMoviesByFilters($genreSql, $titleSql, $genreFilter, $titleFilter);
    return $movies;
}