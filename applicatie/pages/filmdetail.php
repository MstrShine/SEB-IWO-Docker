<!DOCTYPE html>
<html lang="en">
<?php
$movie;
$cast;
$directors;

$title = "Fletnix";
require_once './modules/head.php';
require_once '../php/connection.php';
require_once '../php/entities/Movie.php';
fetchData();
?>

<body>
    <?php require_once './modules/navbar.php'; ?>
    <main class="movie-grid">
        <div class="movie">
            <h2><?= $movie['title'] ?></h2>
            <div class="center-video">
                <?php
                $src = '../assets/movies/' . $movie['URL'];
                $display = <<<HTML
                    <video controls>
                        <source src="$src" type="video/mp4">
                    </video>
                HTML;
                echo ($display);
                ?>
            </div>
            <h4>Description:</h4>
            <p><?= $movie['description'] ?></p>
        </div>
        <div class="cast">
            <h2>Cast:</h2>
            <ul>
                <?php
                foreach ($cast as $c) {
                    $castString = '' . $c['firstname'] . ' ' . $c['lastname'] . ' as ' . str_replace(['[', ']'], '', $c['role']);
                    echo ("<li>$castString</li>");
                }
                ?>
            </ul>
        </div>
        <div class="director">
            <h2>Director(s):</h2>
            <?php
            foreach ($directors as $d) {
                $directorString = '' . $d['firstname'] . ' ' . $d['lastname'];
                echo ("<li>$directorString</li>");
            }
            ?>
        </div>
    </main>
</body>

</html>

<?php
function fetchData()
{
    global $movie;
    global $cast;
    global $directors;
    $filmId = $_GET["fid"];
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
?>