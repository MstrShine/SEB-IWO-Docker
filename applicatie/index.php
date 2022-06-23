<?php
require_once('./pages/modules/carousel.php');
$title = 'Fletnix';
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('./pages/modules/head.php'); ?>

<body>
    <?php require_once('./pages/modules/navbar.php'); ?>
    <main class="grid-body">
        <div class="welcome">
            <?php if (isset($_SESSION['loggedIn'])) {
                echo ("<h2>Welcome back <span>" . $_SESSION['name'] . "</span>!</h2>");
            } else {
                $welcome = <<<HTML
                <h2>Welcome, take a look at our movies!</h2>
                <a href="pages/login.php">Or login/register here</a>
            HTML;
                echo ($welcome);
            } ?>
        </div>
        <div class="carousel">
            <h2 class="carousel-title">Action</h2>
            <?php
            createCarousel('Action');
            ?>
        </div>
        <div class="carousel">
            <h2 class="carousel-title">Thriller</h2>
            <?php
            createCarousel('Thriller');
            ?>
        </div>
    </main>

    <?php require_once('html/svg.html') ?>
</body>

</html>