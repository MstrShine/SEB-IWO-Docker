<!DOCTYPE html>
<html lang="en">
<?php
$title = 'Fletnix - Search';
require_once './modules/head.php';
require_once '../php/connection.php';
require_once '../models/Genre.php';

$genres;
$movies = array();
fetchFilterData();
function fetchFilterData()
{
    global $genres;

    $pdo = new pdo_mssql();
    $genres = $pdo->selectAll(new Genre());
}

if (isset($_GET['genre']) || isset($_GET['title'])) {
    search();
}

function search()
{
    global $movies;
    $sGenre = $_GET['genre'] ?? array();
    $gTitle = $_GET['title'];

    $genreSql = '';
    if (count($sGenre) > 0 || $sGenre != null) {
        $genreSql = "MG.genre_name in (";
        $i = 0;
        foreach ($sGenre as $genre) {
            if ($i == 0) {
                $genreSql .= "'" . $genre . "'";
                $i++;
            } else {
                $genreSql .= ", '" . $genre . "'";
            }
        }
        $genreSql .= ')';
    }

    $titleSql = "";
    if ($gTitle != '') {
        $titleSql .= "M.title like ?";
    }

    if ($titleSql == '' && $genreSql == '') {
        return;
    }

    $sql = "SELECT 
        M.movie_id as fid,
        M.title as title, 
        M.description as description, 
        M.duration as duration, 
        M.cover_image as image, 
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
    if ($titleSql != '') {
        $stmt->execute(['%' . $gTitle . '%']);
    } else {
        $stmt->execute();
    }
    $movies = $stmt->fetchAll();
}
?>

<body>
    <?php require_once './modules/navbar.php'; ?>
    <main class="search-grid">
        <div class="filters">
            <form id="search-box" method="get">
                <h3>Genre filter</h3>
                <?php
                foreach ($genres as $genre) {
                    $genreName = $genre['genre_name'];
                    $genreString = <<<HTML
                    <div>
                        <label for="$genreName">$genreName</label>
                        <input type="checkbox" id="$genreName" name="genre[]" value="$genreName">
                    </div>
                    HTML;
                    echo ($genreString);
                }
                ?>
            </form>
        </div>
        <div class="search">
            <input type="search" form="search-box" name="title" class="simple-input">
            <button class="simple-btn" type="submit" form="search-box">Search</button>
        </div>
        <div class="content">
            <div class="result">
                <?php foreach ($movies as $movie) : ?>
                <div class="movie-card">
                    <a href="/pages/filmdetail.php?fid=<?= $movie['fid'] ?>">
                        <div class="movie-card-grid">
                            <img src="../assets/images/<?= $movie['image'] ?>" alt="">
                            <div class="movie-card-info">
                                <h2><?= $movie['title'] ?></h2>
                                <p><span>Genre:</span><?= $movie['genre'] ?></p>
                                <p><span>Description:</span><?= $movie['description'] ?></p>
                                <p><span>Duration:</span><?= $movie['duration'] ?> minutes</p>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>

</html>