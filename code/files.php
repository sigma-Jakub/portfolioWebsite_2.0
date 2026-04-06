<?php
    // SESSION STARTS
    session_start();
    include "dbHandler.php";

    // POTENTIAL ERROR MESSAGE FOR THE FORM
    $outputMsg = "";

    // <title></title> WEBSITE TITLR DEPENDANT ON THE SELECTED YEAR
    $titleNameBasedOnId = getTitleNameBasedOnId();

    // FORM VALIDATION
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        $titleNameBasedOnId = getTitleNameBasedOnParam($id);
        $outputMsg = addFile();

        if(empty($outputMsg)) {
            header("Location: files.php?id=" . $id . "");
            exit();
        }
    }

    // GET ID DEPENDING ON THE FORM SUBMISSION
    if(!empty($_GET["id"])) {
        $id = $_GET["id"];
    } elseif(!empty($_POST["id"])) {
        $id = $_POST["id"];
    } else {
        header("Location: 404page.php");
        exit();
    }

    // CHECK IF USER IS LOGGED IN
    if(empty($_SESSION["display"])){
        header("Location: locked.php");
        exit();
    }
    else {
        $displayView = $_SESSION["display"];
        $capitalDisplayView = strtoupper($displayView);
    }

    // FUNCTIONS

    // RETURNS USER PERMISSION LEVEL
    function getUserPermission() {
        global $dbHandler;
        $username = $_SESSION["display"];

        if($dbHandler) {
            try {
                $stmt = $dbHandler->prepare("SELECT * FROM `users` WHERE `username` = :username;");
                $stmt->bindParam("username", $username, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                return $user["permission_level"];
            } catch(Exception $ex) {
                echo $ex;
            }
        }
    }

    // RETURNES USER ROLE
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

    // GETS VALUES FROM DB TO DISPLAY IN FILE UPLOADER DROPDOWN SELECT BOX
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

    // DISPLAYING MODULES FROM DB
    function showModules($id) {
        global $dbHandler;
        global $id;

        if($dbHandler) {
            try {
                $stmt = $dbHandler->prepare("SELECT * FROM `modules` WHERE `year_id` = :id;");
                $stmt->bindParam("id", $id, PDO::PARAM_STR);
                $stmt->execute();
                $modules = $stmt->fetchall(PDO::FETCH_ASSOC);

                foreach($modules as $module) {
                    echo '
                        <div class="module-container">
                            <div class="module-shadow">
                                <div class="module-title-container">
                                    <div class="module-title-content">
                                        <div class="module-color"></div>
                                        <div class="module-color-line"></div>
                                        <div class="module-title">' . $module["module_name"] . '</div>
                                    </div>
                                </div>
                            </div>
                            <div class="files-container-grid">
                        ';
                        
                    getFilesBasedOnModule($module["id"]);
                    
                    echo '
                            </div>
                        </div>
                    ';
                }
            } catch(Exception $ex) {
                echo $ex;
            }
        }
    }

    // GETS YEAR ID TO DISPLAY AFTER ENTERING A PAGE
    function getTitleNameBasedOnId() {
        global $dbHandler;

        if(!empty($_GET["id"])) {
            $id = $_GET["id"];

            if(!checkAccessibility($id)) {
                header("Location: 404page.php");
                exit();
            } else {
                if($dbHandler) {
                    try {
                        $stmt = $dbHandler->prepare("SELECT * FROM `years` WHERE `id` = :id;");
                        $stmt->bindParam("id", $id, PDO::PARAM_STR);
                        $stmt->execute();
                        $year = $stmt->fetch(PDO::FETCH_ASSOC);

                        return strtoupper($year["year_label"]);
                    } catch(Exception $ex) {
                        echo $ex;
                    }
                }
            }
        } else if(!empty($_POST["id"])) {
            $id = $_POST["id"];

            if(!checkAccessibility($id)) {
                header("Location: 404page.php");
                exit();
            } else {
                if($dbHandler) {
                    try {
                        $stmt = $dbHandler->prepare("SELECT * FROM `years` WHERE `id` = :id;");
                        $stmt->bindParam("id", $id, PDO::PARAM_STR);
                        $stmt->execute();
                        $year = $stmt->fetch(PDO::FETCH_ASSOC);

                        return $year["year_label"];
                    } catch(Exception $ex) {
                        echo $ex;
                    }
                }
            } 
        } else {
            header("Location: 404page.php");
            exit();
        }
    }

    // GETS YEAR ID TO DISPLAY AFTER FORM SUBMISSION (needs param)
    function getTitleNameBasedOnParam($id) {
        global $dbHandler;

        if($dbHandler) {
            try {
                $stmt = $dbHandler->prepare("SELECT * FROM `years` WHERE `id` = :id;");
                $stmt->bindParam("id", $id, PDO::PARAM_STR);
                $stmt->execute();
                $year = $stmt->fetch(PDO::FETCH_ASSOC);

                return $year["year_label"];
            } catch(Exception $ex) {
                echo $ex;
            }
        }
    }

    // CHECKS IF THE YEAR ID MATCHES DATABASE DATA
    function checkAccessibility($id) {
        global $dbHandler;

        if($dbHandler) {
            try {
                $stmt = $dbHandler->prepare("SELECT * FROM `years`;");
                $stmt->execute();
                $ids = $stmt->fetchall(PDO::FETCH_ASSOC);

                foreach($ids as $yearId) {
                    if($yearId["id"] == $id) {
                        return true;
                    }
                }

                return false;
            } catch(Exception $ex) {
                echo $ex;
            }
        }
    }

    // CHECKS FOR BOTH PERMISSIONS AND ROLE AND DEPENDING ON THE OUTCOME SHOWS APPROPRIATE
    function getFilesBasedOnModule($moduleId) {
        global $dbHandler;

        $userPermission = getUserPermission();
        $userRole = getUserRole();

        if($userRole === "admin") {
            if($dbHandler) {
                try {
                    $stmt = $dbHandler->prepare("SELECT * FROM `projects` WHERE `module_id` = :moduleId ORDER BY `title`;");
                    $stmt->bindParam("moduleId", $moduleId, PDO::PARAM_INT);
                    $stmt->execute();
                    $files = $stmt->fetchall(PDO::FETCH_ASSOC);

                    foreach($files as $file) {
                        echo '
                            <div class="user-file-container">
                                <div class="file-content">
                                    <p class="file-title">' . $file["title"] . '</p>
                                    <p class="file-description">' . $file["description"] . '</p>
                                        <div class="file-buttons-container">
                                            <a href="edit.php?id=' . $file["id"] . '" class="file-button">EDIT</a>
                                            <div class="file-button-divider"></div>
                                            <a href="../uploads/' . $file["file_url"] . '" download class="file-button">DOWNLOAD</a>
                                            <div class="file-sub-container">
                                                <a href="delete.php?id=' . $file["id"] . '" class="file-sub-button">DELETE</a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        ';
                    }
                } catch(Exception $ex) {
                    echo $ex;
                }
            }
        } else {
            if($dbHandler) {
                try {
                    $stmt = $dbHandler->prepare("SELECT * FROM `projects` WHERE `module_id` = :moduleId AND FIND_IN_SET(:userPermission, `permissions`) ORDER BY `title`;");
                    $stmt->bindParam("moduleId", $moduleId, PDO::PARAM_INT);
                    $stmt->bindParam("userPermission", $userPermission, PDO::PARAM_STR);
                    $stmt->execute();
                    $files = $stmt->fetchall(PDO::FETCH_ASSOC);

                    foreach($files as $file) {
                        $fileExt = getFileExtension($file["file_url"]);

                        if($fileExt == "PDF"){
                            echo '
                                <div class="user-file-container">
                                    <div class="file-content">
                                        <p class="file-title">' . $file["title"] . '</p>
                                        <p class="file-description">' . $file["description"] . '</p>
                                        <div class="file-buttons-container">
                                            <a href="../uploads/' . $file["file_url"] . '" target="_blank" class="file-button">VIEW</a>
                                            <div class="file-button-divider"></div>
                                            <a href="../uploads/' . $file["file_url"] . '" download class="file-button">DOWNLOAD</a>
                                            <div class="file-ext">
                                                <p class="file-subtitle ext-color-pdf">' . $fileExt . ' FILE</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ';
                        } else if($fileExt == "DOCX") {
                            echo '
                                <div class="user-file-container">
                                    <div class="file-content">
                                        <p class="file-title">' . $file["title"] . '</p>
                                        <p class="file-description">' . $file["description"] . '</p>
                                        <div class="file-buttons-container">
                                            <a href="../uploads/' . $file["file_url"] . '" target="_blank" class="file-button view-disabled">VIEW</a>
                                            <div class="file-button-divider"></div>
                                            <a href="../uploads/' . $file["file_url"] . '" download class="file-button">DOWNLOAD</a>
                                            <div class="file-ext">
                                                <p class="file-subtitle ext-color-docx">' . $fileExt . ' FILE</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ';
                        } else if($fileExt == "JPG" || $fileExt == "JPEG" || $fileExt == "PNG" || $fileExt == "SVG" || $fileExt == "WEBP" || $fileExt == "GIF") {
                            echo '
                                <div class="user-file-container">
                                    <div class="file-content">
                                        <p class="file-title">' . $file["title"] . '</p>
                                        <p class="file-description">' . $file["description"] . '</p>
                                        <div class="file-buttons-container">
                                            <a href="../uploads/' . $file["file_url"] . '" target="_blank" class="file-button view-disabled">VIEW</a>
                                            <div class="file-button-divider"></div>
                                            <a href="../uploads/' . $file["file_url"] . '" download class="file-button">DOWNLOAD</a>
                                            <div class="file-ext">
                                                <p class="file-subtitle ext-color-img">' . $fileExt . ' FILE</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            '; 
                        } else if($fileExt == "XLSX") {
                            echo '
                                <div class="user-file-container">
                                    <div class="file-content">
                                        <p class="file-title">' . $file["title"] . '</p>
                                        <p class="file-description">' . $file["description"] . '</p>
                                        <div class="file-buttons-container">
                                            <a href="../uploads/' . $file["file_url"] . '" target="_blank" class="file-button view-disabled">VIEW</a>
                                            <div class="file-button-divider"></div>
                                            <a href="../uploads/' . $file["file_url"] . '" download class="file-button">DOWNLOAD</a>
                                            <div class="file-ext">
                                                <p class="file-subtitle ext-color-excel">' . $fileExt . ' FILE</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            '; 
                        } else if($fileExt == "PPTM" || $fileExt == "PPSX" || $fileExt == "PPTX") {
                            echo '
                                <div class="user-file-container">
                                    <div class="file-content">
                                        <p class="file-title">' . $file["title"] . '</p>
                                        <p class="file-description">' . $file["description"] . '</p>
                                        <div class="file-buttons-container">
                                            <a href="../uploads/' . $file["file_url"] . '" target="_blank" class="file-button view-disabled">VIEW</a>
                                            <div class="file-button-divider"></div>
                                            <a href="../uploads/' . $file["file_url"] . '" download class="file-button">DOWNLOAD</a>
                                            <div class="file-ext">
                                                <p class="file-subtitle ext-color-pp">' . $fileExt . ' FILE</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            '; 
                        } else if($fileExt == "ZIP") {
                            echo '
                                <div class="user-file-container">
                                    <div class="file-content">
                                        <p class="file-title">' . $file["title"] . '</p>
                                        <p class="file-description">' . $file["description"] . '</p>
                                        <div class="file-buttons-container">
                                            <a href="../uploads/' . $file["file_url"] . '" target="_blank" class="file-button view-disabled">VIEW</a>
                                            <div class="file-button-divider"></div>
                                            <a href="../uploads/' . $file["file_url"] . '" download class="file-button">DOWNLOAD</a>
                                            <div class="file-ext">
                                                <p class="file-subtitle ext-color-zip">' . $fileExt . ' FILE</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            '; 
                        } else {
                            echo '
                                <div class="user-file-container">
                                    <div class="file-content">
                                        <p class="file-title">' . $file["title"] . '</p>
                                        <p class="file-description">' . $file["description"] . '</p>
                                        <div class="file-buttons-container">
                                            <a href="../uploads/' . $file["file_url"] . '" target="_blank" class="file-button view-disabled">VIEW</a>
                                            <div class="file-button-divider"></div>
                                            <a href="../uploads/' . $file["file_url"] . '" download class="file-button">DOWNLOAD</a>
                                            <div class="file-ext">
                                                <p class="file-subtitle ext-color-other">' . $fileExt . ' FILE</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            '; 
                        }
                    }
                } catch(Exception $ex) {
                    echo $ex;
                }
            }
        }
    }

    function getFileExtension($file) {
        return strtoupper(pathinfo($file, PATHINFO_EXTENSION));
    }

    // CHECKS THE USER ROLE AND IF ITS ADMIN SHOWS THE ADMIN PANEL
    function showAdminPanel($id, $outputMsg) {
        $userRole = getUserRole();
    
if($userRole === "admin") {
    echo '
    <div class="admin-panel-container">
        <div class="file-uploader-container">
            <p class="file-uploader-title">// ADD FILE //</p>
            <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="' . htmlspecialchars($id) . '">
                
                <div class="file-uploader-sub-container">
                    <label for="mname">//MODULE NAME.....</label>
                    <select name="mname" id="mname">';
                        getModulesToBeSelected();
    echo '          </select>
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
                            <input type="checkbox" name="permissions[]" value="employer" id="permission-employer" class="permission-check" checked>
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
                ' . $outputMsg . '
            </form>
        </div>';
    echo '
            <div class="database-controls-container">
                <div class="db-button-wrapper">
                    <a href="http://localhost:8080/" target="_blank">ACCESS_DATABASE_LOGS</a>
                </div>
            </div>';
    getUsersTable(); 
    echo '</div>'; 
}
    }

    // PRINTS USER TABLE FOR ADMIN
    function getUsersTable() {
        global $dbHandler;
    
        if($dbHandler) {
            try {
                $stmt = $dbHandler->prepare("SELECT * FROM  `users`;");
                $stmt->execute();
                $users = $stmt->fetchall(PDO::FETCH_ASSOC);

                echo '
                <table>
                    <tr>
                        <th>ID</th>
                        <th>USERNAME</th>
                        <th>ROLE</th>
                        <th>PERMISSION</th>
                    </tr>';
                foreach($users as $user) {
                echo '
                    <tr>
                        <td>' . $user["id"] . '</td>
                        <td>' . $user["username"] . '</td>
                        <td>' . $user["role"] . '</td>
                        <td>' . $user["permission_level"] . '</td>
                    </tr>';
                }
                echo "</table>";
            } catch(Exception $ex) {
                echo $ex;
            }
        }
    }

    // VALIDATE AND ADD FILE TO BOTH DB AND FOLDER
    function addFile() {
        global $dbHandler;

        $outputMsg = "";

        $moduleId = filter_input(INPUT_POST, "mname");
        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $permissions = filter_input(INPUT_POST, "permissions", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        
        $fileName = $_FILES["file"]["name"];
        $tmp = $_FILES["file"]["tmp_name"];
        $error = $_FILES["file"]["error"];

        $filePath = "../uploads/" . $fileName . "";
        $allowedExt = [
        "application/pdf", 
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "application/msword", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", 
        "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.presentationml.presentation", 
        "application/vnd.ms-powerpoint", "image/png", "image/jpeg", "application/octet-stream", "application/vnd.astah", "text/plain", "application/zip", "application/x-zip-compressed"];
        
        if(empty($title) || empty($description) || empty($permissions) || empty($moduleId) || !empty($error)) {
            $outputMsg = "<p class='pink-error'>Fill up all the inputs.</p>";
        } else {
            $permissionsStr = implode(",", $permissions);
            
            $of = finfo_open(FILEINFO_MIME_TYPE);
            $uploadedExt = finfo_file($of, $tmp);

            if(!in_array($uploadedExt, $allowedExt)) {
                $outputMsg = "<p class='pink-error'>This file type is not allowed.</p>";
            } else {
                if($dbHandler) {
                    try {
                        $stmt = $dbHandler->prepare("INSERT INTO `projects`(`module_id`, `title`, `description`, `permissions`, `file_url`) 
                                                    VALUES(:moduleId, :title, :description, :permissions, :filePath)");

                        $stmt->bindParam("moduleId", $moduleId, PDO::PARAM_INT);
                        $stmt->bindParam("title", $title,  PDO::PARAM_STR);
                        $stmt->bindParam("description", $description, PDO::PARAM_STR);
                        $stmt->bindParam("permissions", $permissionsStr, PDO::PARAM_STR);
                        $stmt->bindParam("filePath", $fileName, PDO::PARAM_STR);
                        $stmt->execute();

                        move_uploaded_file($tmp, $filePath);
                    } catch(Exception $ex) {
                        echo $ex;
                    }
                }
            }
        }
        return $outputMsg;
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
    <title>// <?php echo $titleNameBasedOnId ?>: JAKUB_MAZUR</title>
    <link rel="icon" href="../images/fav_icon.png">
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/files.css">
    <script src="../scripts/uncheck.js"></script>
</head>
<body>
    <div class="header-container">
        <div class="buttons-flex">
            <a href="about.php" class="header-button">ABOUT</a>
            <a href="portfolio.php" class="header-button">PORTFOLIO</a>
            <a href="logout.php" class="header-button">LOG_OUT</a>
        </div>
        <hr class="header-divider">
    </div>
    <div class="module-container-grid">
        <?php showModules($id) ?>
    </div>
    <div>
        <?php showAdminPanel($id, $outputMsg); ?>
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
    <div class="back-to-portfolio-container">
        <a href="portfolio.php" class="back-to-portfolio-button">BACK_TO_PORTFOLIO</a>
    </div>
</body>
</html>