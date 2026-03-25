<?php
    session_start();
    include "dbHandler.php";

    if(getUserRole() !== "admin") {
        header("Location: locked.php");
        exit();
    }

    if(empty($_GET["id"])) {
        header("Location: 404page.php");
        exit();
    }

    function getProjectDataBasedOnName($columnName) {
        global $dbHandler;
        $id = $_GET["id"];

        if($dbHandler) {
            try {
                $stmt = $dbHandler->prepare("SELECT * FROM `projects` WHERE `id` = :id;");
                $stmt->bindParam("id", $id, PDO::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if(!empty($row[$columnName])) {
                    return $row[$columnName];
                } else {
                    return;
                }
            } catch(Exception $ex) {
                echo $ex;
            }
        }
        return;
    }

    function getUserRole() {
        global $dbHandler;
        $username = $_SESSION["display"];

        if($dbHandler) {
            try {
                $stmt = $dbHandler->prepare("SELECT * FROM `users` WHERE `username` = :username;");
                $stmt->bindParam("username", $username, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                return $user["role"];
            } catch(Exception $ex) {
                echo $ex;
            }
        }
    }

    function getModulesToBeSelected() {
        global $dbHandler;
        
        if($dbHandler) {
            try {
                $stmt = $dbHandler->prepare("SELECT * FROM `modules`;");
                $stmt->execute();
                $modules = $stmt->fetchall(PDO::FETCH_ASSOC);

                foreach($modules as $module) {
                    echo '<option value="' . $module["id"] . '">' . $module["module_name"] . '</option>';
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
    <title>Jakub Mazur | Edit - <?php echo getProjectDataBasedOnName("title") ?></title>
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/edit.css">
    <script src="../scripts/uncheck.js"></script>
</head>
<body>
    <div class="file-uploader-container">
        <p class="file-uploader-title">// ADD FILE //</p>
        <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
            <div class="file-uploader-sub-container">
                <label for="mname">//MODULE NAME.....</label>
                <select name="mname" id="mname">';
                    <?php getModulesToBeSelected(); ?>
                </select>
            </div>
            <div class="file-uploader-sub-container">
                <label for="title">//TITLE.....</label>
                <input type="text" name="title" id="title">
            </div>
            <div class="file-uploader-sub-container">
                <label for="description">//DESCRIPTION.....</label>
                <input type="text" name="description" id="description">
            </div>
            <div class="file-uploader-sub-container">
                <label>//PERMISSIONS.....</label>
                <div class="file-permissions-container">
                    <div>
                        <input type="checkbox" name="permissions[]" value="friend" id="permission-friend" class="permission-check" checked>
                        <label for="permission-friend">friends</label>
                    </div>
                    <div>    
                        <input type="checkbox" name="permissions[]" value="lecturer" id="permission-lecturer" class="permission-check" checked>
                        <label for="permission-lecturer">lecturers</label>
                    </div>
                    <div>
                        <input type="checkbox" name="permissions[]" value="employers" id="permission-employer" class="permission-check" checked>
                        <label for="permission-employer">employers</label>
                    </div>
                    <div>
                        <input type="checkbox" name="permissions[]" value="nobody" id="permission-nobody">
                        <label for="permission-nobody">nobody</label>
                    </div>
                </div>
            </div>
            <div class="file-uploader-sub-container">
                <label for="file">//UPLOAD FILE.....</label>
                <input type="file" name="file" id="file">
            </div>
            <div class="file-uploader-submit-container">
                <input type="submit" name="submit" id="submit" value="Add File">
            </div>
        </form>
    </div>
    <div class="file-buttons-container">
        <a href="">BACK TO FILES</a>
        <a href="">ACCESS DATABASE</a>
    </div>
</body>
</html>