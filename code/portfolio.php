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
    <script src="../scripts/graduation.js"></script>
    <script src="../scripts/time.js"></script>
</head>
<body>
    <div class="header-container">
        <div class="buttons-flex">
            <a href="#" class="header-button">CONTACT</a>
            <a href="portfolio.php" class="header-button selected-button">PORTFOLIO</a>
            <a href="logout.php" class="header-button">LOG OUT</a>
        </div>
        <hr class="header-divider">
    </div>
    <div class="cards-container-grid">
        <div class="card-wrapper">
            <a href="#" class="card-click">
                <div class="card-container">
                    <div class="card-content">
                        <div class="card-title">WEB_DEVELOPMENT <span class="card-year">[YEAR 1]</span> </div>
                        <img src="../images/webdev.png" alt="webdev-img" class="card-image">
                    </div>
                </div>
            </a>
            <div class="percentage-text">100%</div>
        </div>
        <div class="card-wrapper">
            <a href="#" class="card-click">
                <div class="card-container">
                    <div class="card-content">
                        <div class="card-title">DATABASE_ENG <span class="card-year">[YEAR 1]</span> </div>
                        <img src="../images/dataeng.png" alt="databse-img" class="card-image">
                    </div>
                </div>
            </a>
            <div class="percentage-text">100%</div>
        </div>
        <div class="card-wrapper">
            <a href="#" class="card-click">
                <div class="card-container">
                    <div class="card-content">
                        <div class="card-title">PROJECT_BATTLEBOT <span class="card-year">[YEAR 1]</span> </div>
                        <img src="../images/battlebot.png" alt="battlebot-img" class="card-image">
                    </div>
                </div>
            </a>
            <div class="percentage-text">100%</div>
        </div>
    </div>
    <div class="years-container-grid">
        <a href="#" class="year-click">
            <div class="year-container">
                <div class="year-content">
                    <div class="year-color"></div>
                    <div class="year-color-line"></div>
                    <div class="year-text">YEAR_1</div>
                </div>
            </div>
        </a>
        <a href="#" class="year-click">
            <div class="year-container">
                <div class="year-content">
                    <div class="year-color"></div>
                    <div class="year-color-line"></div>
                    <div class="year-text">YEAR_2</div>
                </div>
            </div>
        </a>
        <a href="#" class="year-click">
            <div class="year-container">
                <div class="year-content">
                    <div class="year-color"></div>
                    <div class="year-color-line"></div>
                    <div class="year-text">YEAR_3</div>
                </div>
            </div>
        </a>
        <a href="#" class="year-click">
            <div class="year-container">
                <div class="year-content">
                    <div class="year-color"></div>
                    <div class="year-color-line"></div>
                    <div class="year-text">YEAR_4</div>
                </div>
            </div>
        </a>
        <a href="#" class="year-click">
            <div class="year-container">
                <div class="year-content">
                    <div class="year-color"></div>
                    <div class="year-color-line"></div>
                    <div class="year-text">PROFESSIONAL_SKILLS</div>
                </div>
            </div>
        </a>
    </div>
    <div class="features-wrapper">
        <div class="bachelor-timer-container">
            <div class="timer-container">
                <p id="timer"></p>
            </div>
            <div class="timer-text-container">
                <div class="timer-text-content">
                    <div class="timer-color"></div>
                    <div class="timer-color-line"></div>
                    <p class="bachelor-timer-text">BSc_ETA</p>
                </div>
            </div>
        </div>
        <div class="current-time-container">
            <div class="live-time-container">
                <p id="live-time"></p>
            </div>
            <div class="timer-text-container">
                <div class="timer-text-content">
                    <div class="timer-color"></div>
                    <div class="timer-color-line"></div>
                    <p class="bachelor-timer-text">SYS_TME</p>
                </div>
            </div>
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