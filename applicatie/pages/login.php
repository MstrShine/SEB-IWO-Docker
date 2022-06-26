<!DOCTYPE html>
<html lang="en">
<?php
$title = 'Fletnix - Login';
require_once './modules/head.php';
if (isset($_SESSION['loggedIn'])) {
    header("Location: /", true, 302);
    exit();
}
?>

<body>
    <?php require_once './modules/navbar.php'; ?>
    <main>
        <section class="login">
            <h2>Login:</h2>
            <form action="../php/login.php" method="post">
                <input required class="simple-input" placeholder="Username" type="text" id="username" name="username">
                <input required class="simple-input" placeholder="Password" type="password" id="password"
                    name="password">
                <button class="simple-btn" type="submit">Log in</button>
            </form>
            <?php if (isset($_SESSION["login-error"])) echo ("<p class=\"error\">" . (string)$_SESSION["login-error"] . "</p>"); ?>
            <form class="redirect-btn" action="pages/login.php#register"><button class="simple-btn">Register</button>
            </form>
        </section>
    </main>
    <?php require_once './register.php'; ?>
</body>

</html>

<?php
unset($_SESSION["login-error"]);
?>