<nav class="navbar">
    <div class="nav-container">
        <input class="checkbox" type="checkbox" name="" id="" />
        <div class="hamburger-lines">
            <span class="line line1"></span>
            <span class="line line2"></span>
            <span class="line line3"></span>
        </div>
        <div class="logo">
            <h1><span class="logo-other">Flet</span>Nix</h1>
        </div>
        <div class="menu-items">
            <li><a href="/">Home</a></li>
            <?php
            if (isset($_SESSION["loggedIn"])) {
                echo ("<li><a href=\"/pages/logout.php\">Log out</a></li>");
            } else {
                echo ("<li><a href=\"/pages/login.php\">Login</a></li>");
            }
            ?>
        </div>
    </div>
</nav>