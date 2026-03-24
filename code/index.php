<?php
    session_start();

    $errorMessage = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $errorMessage = validateInput();
    }

    function validateInput() {
        $un = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pw = filter_input(INPUT_POST, "password");

        if(empty($un) || empty($pw)) {
            return "<p class='error'>Both inputs must be filled up.</p>";
        } else {
            require_once("dbHandler.php");
            if($dbHandler) {
                try {
                    $stmt = $dbHandler->prepare("SELECT * FROM `users` WHERE `username` = :un LIMIT 1;");
                    $stmt->bindParam("un", $un, PDO::PARAM_STR);
                    $stmt->execute();

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if($row && password_verify($pw, $row["password"])) {
                        $_SESSION["display"] = $row["username"];
                        header("Location: portfolio.php");
                        exit();
                    } else {
                        return "<p class='error'>Invalid username or password.</p>";
                    }
                } catch(Exception $ex) {
                    echo $ex;
                }
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
    <title>Log In | Jakub Mazur</title>
    <link rel="icon" href="../images/fav_icon.png">
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>
    <div class="login-container">
        <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
            <div class="form-content">
                <p class="login-text">LOG_IN</p>
                <div class="input-container">
                    <label for="username">username</label>
                    <input type="text" name="username" id="username">
                </div>
                <div class="input-container">
                    <label for="password">password</label>
                    <input type="password" name="password" id="password">
                </div>
                <div class="button-container">
                    <div class="button-content">
                        <input type="submit" name="submit" id="submit" value="Log in">
                    </div>
                </div>
                <div class="error-container">
                    <?php echo $errorMessage ?>
                </div>
                <div class="signup-container">
                    <p class="signup-text">No account? <a href="signup.php" class="signup-link">Sign up here.</a></p>
                </div>
            </div>
        </form>
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
                <p class="session-value">[LOGIN_REQUIRED_0x0]</p>
            </div>
        </div>
    </footer>
</body>
</html>