<?php
$title = 'Fletnix';
if (isset($_SESSION['loggedIn'])) {
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('./pages/modules/head.php'); ?>

<body>
    <?php require_once('./pages/modules/navbar.php'); ?>
    <main id="grid-body">
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
        <div>
            <h2 class="carousel-title">Test</h2>
            <?php
            include('./pages/modules/carousel.php');
            ?>
        </div>

    </main>

    <?php require_once('html/svg.html') ?>
</body>

</html>