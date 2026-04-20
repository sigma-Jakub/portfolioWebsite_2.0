<?php
    session_start();
    include "dbHandler.php";

    if(empty($_SESSION["display"])){
        header("Location: locked.php");
        exit();
    }
    else {
        $displayView = $_SESSION["display"];
        $capitalDisplayView = strtoupper($displayView);
    }

    function displayMessageTitles() {
        global $dbHandler;

        if($dbHandler) {
            try {
                $stmt = $dbHandler->prepare("SELECT * FROM `news`;");
                $stmt->execute();
                $titles = $stmt->fetchall(PDO::FETCH_ASSOC);

                foreach($titles as $title) {
                    echo '
                        <div class="message-container">
                            <div class="message-chip-container">
                                <div class="message-chip-content"></div>
                            </div>
                            <div class="message-title-container">
                                <div class="message-title-content">
                                    <div class="message-title-color"></div>
                                    <div class="message-color-line"></div>
                                    <div class="title-text">' . $title["title"] . '</div>
                                </div>
                            </div>
                        </div>      
                    ';
                }
            } catch(Exception $ex) {
                echo $ex;
            }
        }
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
    <title>// NEWS: JAKUB_MAZUR</title>
    <link rel="icon" href="../images/fav_icon.png">
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/news.css">
</head>
<body>
    <div class="header-container">
        <div class="buttons-flex">
            <div class="buttons-left"></div>
            <div class="buttons-middle">
                <a href="about.php" class="header-button">ABOUT</a>
                <a href="portfolio.php" class="header-button">PORTFOLIO</a>
                <a href="news.php" class="header-button selected-button">NEWS</a>
            </div>
            <div class="buttons-right">
                <a href="logout.php" class="logout-button">LOG_OUT</a>
            </div>
        </div>
        <hr class="header-divider">
    </div>
    <div class="news-container">
        <div class="news-box">
            <?php displayMessageTitles() ?>
        </div>
    </div>
    <footer>
        <hr class="footer-divider">
        <div class="footer-flex">
            <div class="left-side">
                <img src="../images/website_logo.png" alt="website_logo" class="website-logo">
                <div>
                    <p class="copyright">// SRC_ORIGIN: CD_PROJEKT_RED_CORE</p>
                    <p class="copyright">// ALL_RIGHTS_RESERVED_TO_JAKUB_MAZUR</p>
                    <p class="copyright">// STAMP: &copy; <?php echo date("Y"); ?></p>
                </div>
            </div>
            <div class="right-side">
                <p class="authentication-session">AUTH_SESSION:</p>
                <p class="positive-session-value">[<?php echo $capitalDisplayView ?>]</p>
            </div>
        </div>
    </footer>
</body>
</html>