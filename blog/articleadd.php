<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Create a new article</title>
        <?php
            // css file and Google fonts references
            require 'lib/references.php';
        ?>
    </head>
    <body>
        <?php
            require 'lib/head1.php';
        ?>
        <h1 class="main_title">Create New Article</h1>
        <?php
            require 'lib/head2.php';
        ?>
        <div class="content">
        <div class="add_article">
        <?php
            if (!isset($_SESSION['user'])) {
                echo 'You must be logged in to access this page. <a href="login.php">Login</a> or <a href="register.php">Register</a>' ;
            } else {
                // here-doc
                function getForm($t, $a) {
                $form = <<< ENDIT
                <form method ="POST">
                        <label for="title" >Title:</label> <input type="text" name="title" value="$t" id="title" size="100"> <br>
                        <label for="article">Article:</label> <textarea name="article" id="article" rows="15" cols="98">$a</textarea> <br>
                        <input type="submit" value="Post">
                </form>
ENDIT;
                return $form;
                }
                $errorList = array();
                
                if (!isset($_POST['title'])) {
                    // STATE 1: first show
                    echo getForm("", "");
                } else {
                    // Extract the submission variables
                    $title = $_POST['title'];
                    $body = $_POST['article'];
                
                    // STATE 2 or 3 (submission received)
                    $errorList = array();
                    
                    // Checks inputs
                    if (strlen($title) < 10) {
                        array_push($errorList, "Article title must be at least 10 characteres long.");
                    } elseif(strlen($title) > 100) {
                        array_push($errorList, "Aricle title must not be more than 100 characteres long.");
                    }
                    if (strlen($body) < 50) {
                        array_push($errorList, "Article must be at least 50 characteres long.");
                    } elseif(strlen($body) > 4000) {
                        array_push($errorList, "Aricle must not be more than 4000 characteres long.");
                    }if($errorList) {
                        echo getForm($title, $body) . "\n";
                        echo '<div class="add_article_error">';
                        echo '<ul>';
                        foreach($errorList as $error) {
                            echo '<li>' . $error . '</li>';
                        }
                        echo '</ul>';
                        echo "</div>";
                    }else {
                        // Inserts article into the database
                        $query = "INSERT INTO article (articleID, authorID, creationTime, title, body) VALUE( NULL, ?, NOW(), ?, ?);";
                        $stmt = mysqli_prepare($dbc, $query);
                        mysqli_stmt_bind_param($stmt, "iss", $_SESSION['userID'], $title, $body );
                        $result = mysqli_stmt_execute($stmt);
                        /*  check the result */
                        if (!$result) {
                            echo "Error while executing query: $stmt<br>" . PHP_EOL;
                            echo "Debugging errno: " . mysqli_connect_errno() . "<br>" . PHP_EOL;
                            echo "Debugging error: " . mysqli_connect_error() . "<br>" . PHP_EOL;
                            exit;
                        }
                        echo '<div class="article">';
                        echo '<p>Article successfully posted.</p>';
                        
                        // Retrieves and presents the link to the article
                        $query = "SELECT articleID FROM article WHERE authorID = ? ORDER BY creationTime DESC LIMIT 1";
                        $stmt = mysqli_prepare($dbc, $query);
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION['userID']);    
                        mysqli_stmt_bind_result($stmt, $articleID);
                        $result = mysqli_stmt_execute($stmt);
                        mysqli_stmt_fetch($stmt);
                        echo '<p>Click <a href="article.php?articleID=' . $articleID . '">here</a> to read the article.</p>';
                        echo '</div>';
                    }
                }
            }
            require 'lib/footer.php';
        ?>
        </div>
    </div>
    </body>
</html>