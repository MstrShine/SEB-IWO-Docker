<!DOCTYPE html>
<html lang="en">
<?php
$movie;
$cast;
$directors;

$title = "Fletnix";
require_once './modules/head.php';
require_once '../php/filmdetail.php';
if (isset($_GET["fid"])) {
    $filmId = $_GET["fid"];
    fetchMovieData($filmId, $movie, $cast, $directors);
}
?>

<body>
    <?php require_once './modules/navbar.php'; ?>
    <main class="movie-grid">
        <div class="movie">
            <h2><?= $movie['title'] ?></h2>
            <div class="center-video">
                <?php
                if (isset($_SESSION['loggedIn'])) {
                    $src = '../assets/movies/' . $movie['URL'];
                    $display = <<<HTML
                        <video controls>
                            <source src="$src" type="video/mp4">
                        </video>
                    HTML;
                    echo ($display);
                } else {
                    echo ('<div><h2>You can\'t watch the movie without an account so please log-in</h2>');
                    echo ('<a href="pages/login.php">you can login or register here</a></div>');
                }
                ?>
            </div>
            <h4>Description:</h4>
            <p><?= $movie['description'] ?></p>
            <p>Duration: <?= $movie['duration'] ?> minutes</p>
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
            <ul>
                <?php
                foreach ($directors as $d) {
                    $directorString = '' . $d['firstname'] . ' ' . $d['lastname'];
                    echo ("<li>$directorString</li>");
                }
                ?>
            </ul>
        </div>
    </main>
</body>

</html>

<?php
$_SESSION['prevPage'] = basename($_SERVER['REQUEST_URI']);
?>