<?php
require_once '../php/connection.php';
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

    $stmt = $pdo->conn->prepare($sql);
    $stmt->execute();
    $movies = $stmt->fetchAll();

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

    $pdo = new pdo_mssql();
    $stmt = $pdo->conn->prepare($sql);
    $exArr = $genreFilter;
    if ($titleSql != '') {
        $exArr[] = '%' . $titleFilter . '%';
        $stmt->execute($exArr);
    } else {
        $stmt->execute($exArr);
    }
    $movies = $stmt->fetchAll();

    return $movies;
}