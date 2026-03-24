<?php
    include "dbHandler.php";
    session_start();

    if(getUserRole() === "admin") {
        $id = $_GET["id"];
        $filePath = "../uploads/";
        $redirectId;

        if($dbHandler) {
            try {
                $stmt = $dbHandler->prepare("SELECT `modules`.year_id FROM `projects` JOIN `modules` ON `projects`.module_id = `modules`.id WHERE `projects`.id = :id;");
                $stmt->bindParam("id", $id, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $redirectId = $result["year_id"];
            } catch(Exception $ex) {
                echo $ex;
            }
        }

        if($dbHandler) {
            try {
                $stmt2 = $dbHandler->prepare("SELECT * FROM `projects` WHERE `id` = :id;");
                $stmt2->bindParam("id", $id, PDO::PARAM_INT);
                $stmt2->execute();
                $project = $stmt2->fetch(PDO::FETCH_ASSOC);

                if(file_exists($filePath . $project["file_url"])) {
                    unlink($filePath . $project["file_url"]);
                }

                $stmt3 = $dbHandler->prepare("DELETE FROM `projects` WHERE `id` = :id;");
                $stmt3->bindParam("id", $id, PDO::PARAM_INT);
                $stmt3->execute();
            } catch(Exception $ex) {
                echo $ex;
            }
        }
        header("Location: files.php?id=" . $redirectId . "");
        exit();
    } else {
        header("Location: locked.php");
        exit();
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
?>