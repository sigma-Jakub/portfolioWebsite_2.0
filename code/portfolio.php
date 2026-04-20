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

        $userId = getUserIdBasedOnDisplay($displayView);
        $permissionLevel = getUserPermissionBasedOnId($userId);
        $capitalPermissionLevel = strtoupper($permissionLevel);
    }

    function getUsersNumber() {
        global $dbHandler;
    
        if($dbHandler) {
            try {
                $stmt = $dbHandler->prepare("SELECT COUNT(`username`) AS total FROM `users`;");
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                return $result["total"];
            } catch(Exception $ex) {
                echo $ex;
            }
        }
    }

    function getModulesNumber() {
        global $dbHandler;
    
        if($dbHandler) {
            try {
                $stmt = $dbHandler->prepare("SELECT COUNT(`module_name`) AS total FROM `modules`;");
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                return $result["total"];
            } catch(Exception $ex) {
                echo $ex;
            }
        }
    }

    function getFilesNumber() {
        global $dbHandler;
    
        if($dbHandler) {
            try {
                $stmt = $dbHandler->prepare("SELECT COUNT(`title`) AS total FROM `projects`;");
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                return $result["total"];
            } catch(Exception $ex) {
                echo $ex;
            }
        }
    }

    function getUserIdBasedOnDisplay($username) {
        global $dbHandler;

        if($dbHandler) {
            try {
                $stmt = $dbHandler->prepare("SELECT * FROM `users` WHERE `username` = :username;");
                $stmt->bindParam("username", $username, PDO::PARAM_STR);
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                return $result["id"];
            } catch(Exception $ex) {
                echo $ex;
            }
        }
    }

    function getUserPermissionBasedOnId($id) {
        global $dbHandler;

        if($dbHandler) {
            try {
                $stmt = $dbHandler->prepare("SELECT * FROM `users` WHERE `id` = :id;");
                $stmt->bindParam("id", $id, PDO::PARAM_INT);
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                return $result["permission_level"];
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
    <title>// PORTFOLIO: JAKUB_MAZUR</title>
    <link rel="icon" href="../images/fav_icon.png">
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/portfolio.css">
    <script src="../scripts/graduation.js"></script>
    <script src="../scripts/time.js"></script>
</head>
<body>
    <div class="header-container">
        <div class="buttons-flex">
            <div class="buttons-left"></div>
            <div class="buttons-middle">
                <a href="about.php" class="header-button">ABOUT</a>
                <a href="portfolio.php" class="header-button selected-button">PORTFOLIO</a>
            </div>
            <div class="buttons-right">
                <a href="logout.php" class="logout-button">LOG_OUT</a>
            </div>
        </div>
        <hr class="header-divider">
    </div>
    <div class="cards-container-grid">
        <div class="card-container i">
            <div class="card-content">
                <p class="card-title ip">USER_PROFILE</p>
                <div class="card-text id">> USER_ID: <span class="card-info is"><?php echo $userId?></span></div>
                <div class="card-text id">> USERNAME: <span class="card-info is"><?php echo $capitalDisplayView?></span></div>
                <div class="card-text id">> PASSWORD: <span class="card-info is">[ENCRYPTED]</span></div>
                <div class="card-text id">> PERMISSION: <span class="card-info is"><?php echo $capitalPermissionLevel?></span></div>
            </div>
        </div>
        <div class="card-container a">
            <div class="card-content">
                <p class="card-title ap">PORTFOLIO_STATS</p>
                <div class="card-text ad">> USER_COUNT: <span class="card-info as"><?php echo getUsersNumber()?></span></div>
                <div class="card-text ad">> MODULE_COUNT: <span class="card-info as"><?php echo getModulesNumber()?></span></div>
                <div class="card-text ad">> FILE_COUNT: <span class="card-info as"><?php echo getFilesNumber()?></span></div>
                <div class="card-text ad">> CONTINOUS_EXPANSION: <span class="card-info as">TRUE</span></div>
            </div>
        </div>
        <div class="card-container g">
            <div class="card-content">
                <p class="card-title gp">SYSTEM_CORE</p>
                <div class="card-text gd">> ENGINE: <span class="card-info gs">PHP_8.4.12</span></div>
                <div class="card-text gd">> MARKUP: <span class="card-info gs">HTML5</span></div>
                <div class="card-text gd">> STYLING: <span class="card-info gs">CSS3</span></div>
                <div class="card-text gd">> DATABASE: <span class="card-info gs">MySQL</span></div>
            </div>
        </div>
    </div>
    <div class="hover-text">STATUS: HOVER_FOR_ACCESS</div>
    <div class="years-container-grid">
        <a href="files.php?id=1" class="year-click">
            <div class="year-container">
                <div class="year-content">
                    <div class="year-color"></div>
                    <div class="year-color-line"></div>
                    <div class="year-text">YEAR_1</div>
                </div>
            </div>
        </a>
        <a href="files.php?id=2" class="year-click">
            <div class="year-container">
                <div class="year-content">
                    <div class="year-color"></div>
                    <div class="year-color-line"></div>
                    <div class="year-text">YEAR_2</div>
                </div>
            </div>
        </a>
        <a href="files.php?id=3" class="year-click">
            <div class="year-container">
                <div class="year-content">
                    <div class="year-color"></div>
                    <div class="year-color-line"></div>
                    <div class="year-text">YEAR_3</div>
                </div>
            </div>
        </a>
        <a href="files.php?id=4" class="year-click">
            <div class="year-container">
                <div class="year-content">
                    <div class="year-color"></div>
                    <div class="year-color-line"></div>
                    <div class="year-text">YEAR_4</div>
                </div>
            </div>
        </a>
        <a href="files.php?id=5" class="year-click">
            <div class="year-container">
                <div class="year-content">
                    <div class="year-color"></div>
                    <div class="year-color-line"></div>
                    <div class="year-text">PROFESSIONAL_SKILLS</div>
                </div>
            </div>
        </a>
    </div>
    <div class="monitor-box-wrapper">
        <div class="monitor-box-container">
            <div class="monitor-box-content">
                <div class="monitor-title-container">
                    <p class="monitor-title">// YEAR_OVERVIEW_MONITOR<span class="pulsing-dot"></span></p>
                </div>
                <div class="monitor-text-container">
                    <div class="monitor text y-one">
                        <span class="green-span">> STATUS: CRITICAL_MODULES_DETECTED</span>
                        // MODULES: <span class="aqua-span">[HTML/CSS] [PHP] [JAVA] [C++] [SQL]</span>
                        // HARDWARE: <span class="aqua-span">[ARDUINO]</span>
                        // CLIENT: <span class="aqua-span">[UI/UX] [FRONTEND_DEV]</span>
                        // SECURE: <span class="aqua-span">[NETWORKS] [CYBER_SAFETY]</span>
                        > UPLINK_STABLE... AWAITING_NEXT_INPUT
                    </div>
                    <div class="monitor text y-two">
                        <span class="green-span">> STATUS: CRITICAL_MODULES_DETECTED</span>
                        // LOGIC: <span class="aqua-span">LOADING...</span>
                        // SYSTEMS: <span class="aqua-span">LOADING...</span>
                        // DEV_PROCESS: <span class="aqua-span">LOADING...</span>
                        // MANAGEMENT: <span class="aqua-span">LOADING...</span>
                        > UPLINK_STABLE... AWAITING_NEXT_INPUT
                    </div>
                    <div class="monitor text y-three">
                        <span class="green-span">> STATUS: CRITICAL_MODULES_DETECTED</span>
                        // FIELD_OPERATIONS: <span class="aqua-span">LOADING...</span>
                        // LOCATION: <span class="aqua-span">LOADING...</span>
                        // SPECIALIZATION: <span class="aqua-span">LOADING...</span>
                        // COMPETENCIES: <span class="aqua-span">LOADING...</span>
                        > UPLINK_STABLE... AWAITING_NEXT_INPUT
                    </div>
                    <div class="monitor text y-four">
                        <span class="green-span">> STATUS: CRITICAL_MODULES_DETECTED</span>
                        // AI_INTEGRATION: <span class="aqua-span">LOADING...</span>
                        // ARCHITECTURE: <span class="aqua-span">LOADING...</span>
                        // METHODOLOGY: <span class="aqua-span">LOADING...</span>
                        // GRADUATION_OUTCOME: <span class="aqua-span">LOADING...</span>
                        > UPLINK_STABLE... AWAITING_NEXT_INPUT
                    </div>
                    <div class="monitor text p-skills">
                        <span class="green-span">> STATUS: CRITICAL_MODULES_DETECTED</span>
                        // DOCUMENTATION: <span class="aqua-span">[TECH_REPORTS]</span>
                        // COLLABORATION: <span class="aqua-span">[TEAM_SYNC] [SCRUM] [FEEDBACK]</span>
                        // COMMUNICATION: <span class="aqua-span">[CLIENT] [STAKEHOLDER]</span>
                        // ADAPTABILITY: <span class="aqua-span">[LOGIC] [SOLVING] [AGILE]</span>
                        > UPLINK_STABLE... AWAITING_NEXT_INPUT
                    </div>
                </div>
            </div>
        </div>
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