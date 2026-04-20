<?php
    session_start();

    if(empty($_SESSION["display"])){
        header("Location: locked.php");
        exit();
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
    <title>// ABOUT: JAKUB_MAZUR</title>
    <link rel="icon" href="../images/fav_icon.png">
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/about.css">
</head>
<body>
    <div class="header-container">
        <div class="buttons-flex">
            <div class="buttons-left"></div>
            <div class="buttons-middle">
                <a href="about.php" class="header-button selected-button">ABOUT</a>
                <a href="portfolio.php" class="header-button">PORTFOLIO</a>
            </div>
            <div class="buttons-right">
                <a href="logout.php" class="logout-button">LOG_OUT</a>
            </div>
        </div>
        <hr class="header-divider">
    </div>
    <div class="about-container">
        <div class="about-title">STATUS: DECRYPTING_USER_PROFILE...<span class="cursor">|</span></div>
        <div class="about-top">
            <div class="pfp-container">
                <img src="../images/VISUAL_REF_01.png" alt="my-pfp" class="profile-picutre">
                <div class="pfp-description">
                    <p class="pfp-text">// FILE_ID: VISUAL_REF_01.PNG</p>
                </div>
            </div>
            <div class="pfp-info-wrapper">
                <div class="info-container-flex">
                    <div class="info-container">
                        <div class="info-content">
                            <div class="info-color"></div>
                            <div class="info-color-line"></div>
                            <div class="info-text"><span class="red-highlight">// FULL_NAME:</span> JAKUB_MAZUR</div>
                        </div>
                    </div>
                    <div class="info-container">
                        <div class="info-content">
                            <div class="info-color"></div>
                            <div class="info-color-line"></div>
                            <div class="info-text"><span class="red-highlight">// CURR_LOCATION:</span> EMMEN // DRENTHE</div>
                        </div>
                    </div>
                    <div class="info-container">
                        <div class="info-content">
                            <div class="info-color"></div>
                            <div class="info-color-line"></div>
                            <div class="info-text"><span class="red-highlight">// CURR_EDUCATION:</span> IT // NHL STENDEN</div>
                        </div>
                    </div>
                    <div class="info-container">
                        <div class="info-content">
                            <div class="info-color"></div>
                            <div class="info-color-line"></div>
                            <div class="info-text"><span class="red-highlight">// LANGUAGES:</span> POLISH // ENGLISH</div>
                        </div>
                    </div>
                </div>
                <div class="uplinks-container">
                    <a href="https://github.com/sigma-Jakub" target="_blank" class="uplink-container-shadow">
                        <div class="uplink-container">
                            <div class="uplink-content">
                                <div class="uplink-color"></div>
                                <div class="uplink-color-line"></div>
                                <div class="uplink-content-text">GITHUB</div>
                            </div>
                        </div>
                    </a>
                    <a href="https://www.linkedin.com/in/jakub-mazur-39a1aa376/" target="_blank" class="uplink-container-shadow">
                        <div class="uplink-container">
                            <div class="uplink-content">
                                <div class="uplink-color"></div>
                                <div class="uplink-color-line"></div>
                                <div class="uplink-content-text">LINKEDIN</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="monologue-shadow">
            <div class="about-monologue">
                <div class="about-monologue-content">
                    <p class="monologue-title">&heartsuit; MESSAGES > JAKUB</p>
                    <p class="monologue-text">
                        I am Informatics enthusiast and IT student at NHL Stenden University of Applied Sciences. 
                        The reason for that choice is my coding and problem solving passion. Outside of my studies, I enjoy extreme sports (mainly chess),
                        gaming and hitting the gym. My current, long term goal is to finish the studies and find IT related job in Spain.
                    </p>
                </div>
            </div>
        </div>
        <div class="about-bottom">
            <div class="card-container-grid">
                <div class="card-container">
                    <div class="card-content">
                        <p class="card-title">TECHNICAL_SKILLS</p>
                        <div class="card-text"><span class="card-title-info">> FRONTEND:</span> <span class="card-info">[HTML] [CSS] [JavaScript]</span></div>
                        <div class="card-text"><span class="card-title-info">> BACKEND:</span> <span class="card-info">[PHP] [SQL] [C++] [Java] [Python]</span></div>
                        <div class="card-text"><span class="card-title-info">> TOOLS_AND_DEVOPS:</span> <span class="card-info">[GitHub] [Docker] [phpMyAdmin] <span class="red-highlight">//</span> [Useberry] [Figma] [Astah] <span class="red-highlight">//</span> [VS Code] [IntelliJ IDEA] [Arduino IDE]</span></div>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card-content">
                        <p class="card-title">EDUCATION</p>
                        <div class="card-text"><span class="card-title-info">> HIGH_SCHOOL</span> <span class="card-info">II Liceum Ogólnokształcące im. J. Śniadeckiego w Kielcach <span class="red-highlight">//</span> Extended: [Mathematics] [Physics] [IT] <span class="red-highlight">//</span> <span class="green-highlight">[2020 - 2024]</span></span></div>
                        <div class="card-text"><span class="card-title-info">> HIGHER_EDUCATION:</span> <span class="card-info">NHL Stenden University of Applied Sciences <span class="red-highlight">//</span> [B.S. Information Technology] <span class="red-highlight">//</span> <span class="green-highlight">[2025 - Present]</span></span></div>
                    </div>
                </div>
                <!-- <div class="card-container">
                    <div class="card-content">
                        <p class="card-title">WORK_EXPERIENCE</p>
                        <div class="card-text">> <span class="card-info"> </span></div>
                        <div class="card-text">> <span class="card-info"> </span></div>
                        <div class="card-text">> <span class="card-info"> </span></div>
                        <div class="card-text">> <span class="card-info"> </span></div>
                    </div>
                </div> -->
                <div class="card-container">
                    <div class="card-content">
                        <p class="card-title">CREDENTIALS</p>
                        <div class="card-text"><span class="card-title-info">> CERTIFICATIONS:</span> <span class="card-info">Python 3: From Beginner to Expert <span class="red-highlight">//</span> Arkadiusz Włodarczyk <span class="red-highlight">//</span> <span class="green-highlight">[2024]</span></span></div>
                        <span class="card-info course">Pre Security Learning Path <span class="red-highlight">//</span> Ashu Savani | Ben Spring <span class="red-highlight">//</span> <span class="green-highlight">[2023]</span></span>
                        <div class="card-text"><span class="card-title-info">> LANGUAGES:</span> <span class="card-info">English <span class="red-highlight">//</span> IELTS Band 7.0</span></div>
                    </div>
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