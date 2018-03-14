<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>View and comment on an article</title>
        <?php
            // css file and Google fonts references
            require 'lib/references.php';
        ?>
    </head>
    <body>
        <?php
            require 'lib/head1.php';
        ?>
        <h1 class="main_title">View and Comment on an Article</h1>
        <?php
            // First part of HTML top bar
            require 'lib/head2.php';
            echo '<div class="content">';
            echo '<div class="article">';
            $articleID = $_GET['articleID'];
            
            // Selects article
            $query = "SELECT article.authorID, article.creationTime, article.title, article.body, user.name FROM article, user WHERE article.authorID = user.userID and article.articleID = ?;";
            $stmt = mysqli_prepare($dbc, $query);
            mysqli_stmt_bind_param($stmt, "i", $articleID);
            
            mysqli_stmt_bind_result($stmt, $authorID, $creationTime, $title, $body, $name);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_fetch($stmt);
            /*  check the result */
            if (!$result) {
                echo "Error while executing query: $stmt<br>" . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . "<br>" . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . "<br>" . PHP_EOL;
                exit;
            }
            mysqli_stmt_close($stmt);
            
            // Displays article
            echo '<div class="article_id">';
            echo '<h2>' . $title. '<br></h2>';
            echo '<br><h3>Posted by '. $name . ' on ' . $creationTime. '<br></h3>';
            echo '<p>'. $body. '<br></p>';
            echo '</div>';
            
            if (!isset($_SESSION['user'])) {
                echo '<div class="no_login">';
                echo '<p>You must be logged in to post comments. <a href="login.php">Login</a> or <a href="register.php">Register</a></p>' ;
                echo '</div>';
            } else {
                function getForm($c) {
                $form = <<< ENDIT
                <form  method ="POST">
                        <label for="comment" >My comment:</label> <textarea name="comment" id="comment" rows="5" cols="100">$c</textarea> <br>
                        <input type="submit" value="Add comment">
                </form>
ENDIT;
                echo '<div class="comment_form">';
                echo '<br>';
                return $form;
                }
                $errorList = array();
                
                if (!isset($_POST['comment'])) {
                    // STATE 1: first show
                    echo getForm("");
                } else {
                    echo '<div class="article_error">';
                    // Extract the submission variables
                    $comment = $_POST['comment'];
                    
                    if (strlen($comment) < 5) {
                        echo '<div class="comment_error">';
                        array_push($errorList, "Comment must be at least 4 characteres long.");
                        foreach($errorList as $error) {
                            echo '<p>' . $error . '</p>';
                        echo '</div>';
                        }
                    } else {
                        // Inserts comment into database
                        $query = "INSERT INTO comment (commentID, articleID, authorID, creationTime, body) VALUE( NULL, ?, ?, NOW(), ?);";
                        $stmt = mysqli_prepare($dbc, $query);
                        mysqli_stmt_bind_param($stmt, "iis", $articleID, $_SESSION['userID'], $comment);
                        $result = mysqli_stmt_execute($stmt);
                        /*  check the result */
                        if (!$result) {
                            echo "Error while executing query: $stmt<br>" . PHP_EOL;
                            echo "Debugging errno: " . mysqli_connect_errno() . "<br>" . PHP_EOL;
                            echo "Debugging error: " . mysqli_connect_error() . "<br>" . PHP_EOL;
                            exit;
                        }
                    }
                    echo '<div class="comment_form">';
                    echo getForm("");
                    echo '</div>';
                    echo '</div>';
                }
            }
            // Selects comments
            $query = "SELECT comment.creationTime, comment.body, user.name from comment, user, article where comment.authorID=user.userID and article.articleID =? and comment.articleID=article.articleID ORDER BY comment.creationTime DESC;";
            $stmt = mysqli_prepare($dbc, $query);
            mysqli_stmt_bind_param($stmt, "i", $articleID);
            mysqli_stmt_bind_result($stmt, $creationTime, $comment, $nameComment);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            /*  check the result */
            if (!$result) {
                echo "Error while executing query: $stmt<br>" . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . "<br>" . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . "<br>" . PHP_EOL;
                exit;
            } elseif (mysqli_stmt_num_rows($stmt) > 0 ) {
                // Display previous comments
                echo '<div class="comments">Previous comments:';
                echo '<ul>';
                while (mysqli_stmt_fetch($stmt)) {
                    echo '<li>' . $nameComment . ' said on ' . date( 'M/d, Y', strtotime($creationTime)) . ' at '. date( 'G:i', strtotime($creationTime)) . '<br>' . $comment . '</li>';
                }
                echo '</ul>';
                echo '</div>';  
            }
            else {
                echo '<div class="comments">No previous comments.</div>';
            }
            echo '</div>';
            require 'lib/footer.php';
        ?>
        </div>
    </body>
</html>