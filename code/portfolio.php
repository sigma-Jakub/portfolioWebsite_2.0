<?php
    session_start();

    if(empty($_SESSION["display"])){
        header("Location: index.php");
    }
    else {
        $displayView = $_SESSION["display"];
        $capitalDisplayView = strtoupper($displayView);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio | Jakub Mazur</title>
    <link rel="icon" href="../images/fav_icon.png">
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/portfolio.css">
</head>
<body>
    <header>
        <div class="buttons-flex">
            <a href="#" class="header-button">CONTACT</a>
            <a href="portfolio.php" class="header-button selected-button">PORTFOLIO</a>
            <a href="logout.php" class="header-button">LOG OUT</a>
        </div>
        <hr class="header-divider">
    </header>
    <footer>
        <hr class="footer-divider">
        <div class="footer-flex">
            <div class="left-side">
                <p class="copyright">copyright &copy; <?php echo date("Y"); ?> by Jakub Mazur. All rights reserved.</p>
                <img src="../images/website_logo.png" alt="website_logo" class="website-logo">
            </div>
            <div class="right-side">
                <p class="authentication-session">AUTH_SESSION:</p>
                <p class="positive-session-value">[ <?php echo $capitalDisplayView ?> ]</p>
            </div>
        </div>
    </footer>
</body>
</html>