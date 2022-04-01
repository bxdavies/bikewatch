<nav>
    <a href="/" class="brand">
        <img class="logo" src="<?php echo '/assets/img/logo.png'; ?>">
        <span> Gloucestershire Constabulary BikeWatch </span>
    </a>

    <!-- responsive-->
    <input id="bmenub" type="checkbox" class="show">
    <label for="bmenub" class="burger button"> &#9776; </label>

    <div class="menu" style="z-index: 400;">
        <?php
            if (isset($_SESSION['role'])) {

                // Role is user
                if ($_SESSION['role'] == 'user') {
        ?>
                    <a href="/user/dashboard/dashboard.php"> Dashboard </a>
                    <a href="#"> Logout</a>
            <?php
                } 
                // Role is police
                else if ($_SESSION['role'] == 'police') {
            ?>
                    <a href="/police/dashboard/dashboard.php"> Dashboard </a>
                    <a href="/police/search/search.php"> Search </a>
                    <a href="/police/heatmap/heatmap.php"> HeatMap </a>
                    <a href="#"> Logout</a>
            <?php
                }
            }
            // Role is not defined
            else {
            ?>
                <a href="/login/login.php">Login</a>
                <a href="/user/register/register.php">Register</a>
        <?php } ?>

    </div>
</nav>