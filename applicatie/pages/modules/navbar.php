<nav class="navbar">
    <div class="nav-container">
        <input class="checkbox" type="checkbox" />
        <div class="hamburger-lines">
            <span class="line line1"></span>
            <span class="line line2"></span>
            <span class="line line3"></span>
        </div>
        <div class="logo">
            <?php if (isset($_SESSION['name'])) {
                $name = $_SESSION['name'];
                echo ("<h3 class=\"login-name\">$name</h3>");
            } ?>
            <h1><a href="/"><span class="logo-other">Flet</span>Nix</a></h1>
        </div>
        <menu class="menu-items">
            <li><a href="/">Home</a></li>
            <li><a href="/pages/search.php">Search</a></li>
            <li><a href="/pages/contact.php">Contact</a></li>
            <?php
            if (isset($_SESSION["loggedIn"])) {
                echo ("<li><a href=\"/php/logout.php\">Log out</a></li>");
            } else {
                echo ("<li><a href=\"/pages/login.php\">Login</a></li>");
            }
            ?>
        </menu>
    </div>
</nav>