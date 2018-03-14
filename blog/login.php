<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>User Login</title>
        <?php
            // css file and Google fonts references
            include 'lib/references.php';
        ?>
    </head>
    <body>
        <?php
            // First part of HTML top bar
            include 'lib/head1.php';
        ?>
        <h1 class="main_title">User Login</h1>
            <div class="session">
                    <?php
                    // Checks if the user is logged in
                    if (isset($_SESSION['user'])) {
                        echo '<p><br>You are logged in as ' . $_SESSION['user'] . '. <a href="logout.php">Logout</a></p>';
                    ?>
                       </div>
                <div class="clear">
                </div>
            </header>
            <div class="banner">
                <a href="https://www.ielts.org/book-a-test/find-a-test-location"> <img src="images/banner.gif" alt=“advertisement_banner” width="728" height="90"> </a>
            </div>  
                
                    <?php
                    // Makes sure a logged user will not see the login form    
                    } else {
                    
                    ?>
                </div>
                <div class="clear">
                </div>
            </header>
            <div class="banner">
                <a href="https://www.ielts.org/book-a-test/find-a-test-location"> <img src="images/banner.gif" alt=“advertisement_banner” width="728" height="90"> </a>
            </div>
            <div class="login">
                <?php
                // here-doc
                function getForm($n, $e) {
                $form = <<< ENDIT
                <form method ="POST">
                        <label for="name" >Username:</label> <input type="text" name="name" value="$n" id="name"> <br>
                        <label for="password">Password:</label> <input type="password" name="pass1" id="password"> <br>
                        <input type="submit" value="Login">
                        <p>No account? Register <a href="register.php">here</a></p>
                </form>
ENDIT;
                return $form;
                echo '</div>';
                }
                $errorList = array();
                
                if (!isset($_POST['name'])) {
                    // STATE 1: first show
                    echo getForm("", "");
                } else {
                    // Extract the submission variables
                    $name = $_POST['name'];
                    $pass1 = $_POST['pass1'];
                
                    // STATE 2 or 3 (submission received)
                
                    $query = "SELECT userID, name, password FROM user WHERE name = ?;";
                    $stmt = mysqli_prepare($dbc, $query);
                    mysqli_stmt_bind_param($stmt, "s", $name);
                    mysqli_stmt_bind_result($stmt, $userID, $user_name, $password);
                    $result = mysqli_stmt_execute($stmt);
                    mysqli_stmt_fetch($stmt);
                    /*  check the result */
                    if (!$result) {
                        echo "Error while executing query: $stmt<br>" . PHP_EOL;
                        echo "Debugging errno: " . mysqli_connect_errno() . "<br>" . PHP_EOL;
                        echo "Debugging error: " . mysqli_connect_error() . "<br>" . PHP_EOL;
                        exit;
                    // Checks credentials    
                    } elseif ($user_name !== $name ) {
                        array_push($errorList, "Invalid credentials.");
                        if($errorList) {
                            echo getForm("", "") . "\n";
                        } 
                    } elseif ($password !== $pass1) {
                            array_push($errorList, "Invalid credentials."); 
                            if($errorList) {
                                echo getForm($name, "") . "\n";
                            }
                    }
                ?>
            </div>
                    <?php
                        // displays errors to the user
                    if ($errorList) {
                        echo '<div class="login_error">';
                        echo '<h3>Login Failed</h3>';
                        echo '<ul>';
                        foreach($errorList as $error) {
                            echo '<li>' . $error . '</li>';
                        }
                        echo '</ul>';
                    }
                    // Create session 
                    else {
                        echo '<div class="login">';
                        $_SESSION['user'] = $name;
                        $_SESSION['userID'] = $userID;
                        echo '<p>You have been successfully logged in.<p>';
                        echo '<p>Click <a href="index.php">here</a> to go to the Home Page</p>';
                        echo '</div>';
                    }
                }
            echo '</div>';    
            }
                // Page footer
                include 'lib/footer.php';
            ?>
    </body>
</html>