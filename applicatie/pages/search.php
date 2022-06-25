<!DOCTYPE html>
<html lang="en">
<?php
$title = 'Fletnix - Search';
require_once './modules/head.php';
require_once '../php/search.php';

$genres = fetchFilterData();
$movies = fetchAllMoviesWithGenre();

if (isset($_GET['genre']) || isset($_GET['title'])) {
    $genreFilter = $_GET['genre'] ?? array();
    $titleFilter = $_GET['title'];
    $movies = searchMoviesByFilters($genreFilter, $titleFilter);
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
                    <a href="/pages/filmdetail.php?fid=<?= $movie['movie_id'] ?>">
                        <div class="movie-card-grid">
                            <img src="../assets/images/<?= $movie['cover_image'] ?>" alt="">
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