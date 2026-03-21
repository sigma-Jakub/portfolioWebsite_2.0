<?php
    session_start();

    $errorMessage = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $errorMessage = validateInput();
    }

    function validateInput(){
        $un = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pw1 = filter_input(INPUT_POST, "password1");
        $pw2 = filter_input(INPUT_POST, "password2");

        if(empty($un) || empty($pw1) || empty($pw2)) {
            return "<p class='error'>All the inputs must be filled up.</p>";
        } 
        else if($pw1 !== $pw2){
            return "<p class='error'>Passwords don't match.</p>";
        } else if(strlen($pw1) < 8){
            return "<p class='error'>Password must contain at least 8 characters.</p>";
        } else {
            require_once("dbHandler.php");
            if($dbHandler) {
                try {
                    $stmt = $dbHandler->prepare("SELECT `username` FROM `users`;");
                    $stmt->execute();

                    $rows = $stmt->fetchall(PDO::FETCH_ASSOC);

                    foreach($rows as $result) {
                        if($result["username"] == $un) {
                            return "<p class='error'>This username is already in use.</p>";
                        }
                    }
                    $hashedPassword = password_hash($pw1, PASSWORD_BCRYPT);

                    if($dbHandler) {
                        try {
                            $stmt2 = $dbHandler->prepare("INSERT INTO users (`username`, `password`, `role`, `permission_level`) VALUES (:username, :hashedpassword, 'visitor', 'public');");
                            $stmt2->bindParam("username", $un, PDO::PARAM_STR);
                            $stmt2->bindParam("hashedpassword", $hashedPassword, PDO::PARAM_STR);

                            $stmt2->execute();

                            return "<p class='success'>Account created successfully.</p>";
                        } catch(Exception $ex) {
                            echo $ex;
                        }
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
    <title>Sign up | Jakub Mazur</title>
    <link rel="icon" href="../images/fav_icon.png">
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/signup.css">
</head>
<body>
    <div class="signup-container">
        <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
            <div class="form-content">
                <p class="signup-text">Sign up</p>
                <div class="input-container">
                    <label for="username">username</label>
                    <input type="text" name="username" id="username">
                </div>
                <div class="input-container">
                    <label for="password1">password</label>
                    <input type="password" name="password1" id="password1">
                </div>
                <div class="input-container">
                    <label for="password2">confirm password</label>
                    <input type="password" name="password2" id="password2">
                </div>
                <div class="button-container">
                    <input type="submit" name="submit" id="submit" value="Sign up">
                </div>
                <div class="error-container">
                    <?php echo $errorMessage ?>
                </div>
                <div class="login-container">
                    <p class="login-text">Existing user? <a href="index.php" class="login-link">Log in here.</a></p>
                </div>
            </div>
        </form>
    </div>
    <footer>
        <hr class="footer-divider">
        <div class="footer-flex">
            <div class="left-side">
                <p class="copyright">copyright &copy; <?php echo date("Y"); ?> by Jakub Mazur. All rights reserved.</p>
                <img src="../images/website_logo.png" alt="website_logo" class="website-logo">
            </div>
            <div class="right-side">
                <p class="authentication-session">AUTH_SESSION:</p>
                <p class="session-value">[LOGIN_REQUIRED_0x0]</p>
            </div>
        </div>
    </footer>
</body>
</html>