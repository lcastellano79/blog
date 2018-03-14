<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>New user registration</title>
        <?php
            require 'lib/references.php';
        ?>
    </head>
    <body>
        <?php
            require 'lib/head1.php';
        ?>
        <h1 class="main_title">New User Registration</h1>
        <?php
            require 'lib/head2.php';
        ?>
            <div class="register">
                <?php
                // here-doc
                function getForm($n, $e) {
                $form = <<< ENDIT
                <form method ="POST">
                    <label for="name" >Desired username:</label> <input type="text" name="name" value="$n" id="name"> <br>
                    <label for="email">Your e-mail:</label> <input type="text" name="email" value="$e" id="email"> <br>
                    <label for="password1">Password:</label> <input type="password" name="pass1" id="password1"> <br>
                    <label for="password2">Password (repeat):</label> <input type="password" name="pass2" id="password2"> <br>
                    <input type="submit" value="Register">
                </form>
ENDIT;
                return $form;
                }


                if (!isset($_POST['name'])) {
                    // STATE 1: first show
                    echo getForm("", "");
                    echo '</div>';
                } else {
                    // Extract the submission variables
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $pass1 = $_POST['pass1'];
                    $pass2 = $_POST['pass2'];
                    // STATE 2 or 3 (submission received)
                    $errorList = array();

                    // Checks user name
                    if (strlen($name) < 4) {
                        array_push($errorList, "User name must be at least 4 characters long.");
                    } elseif(strlen($name) > 20) {
                        array_push($errorList, "User name must not be more than 20 characters long.");
                    }
                    if (!ctype_alnum($name) || (strtolower($name) !== $name)) {
                        array_push($errorList, "User name must only consist of lower case letters and numbers.");
                        
                    // Checks if it is a new user name
                    } else { 
                        $query = "SELECT name FROM user WHERE name = ?;";
                        $stmt = mysqli_prepare($dbc, $query);
                        mysqli_stmt_bind_param($stmt, "s", $name );
                        mysqli_stmt_bind_result($stmt, $userID);
                        $result = mysqli_stmt_execute($stmt);
                        mysqli_stmt_fetch($stmt);
                        /*  check the result */
                        if (!$result) {
                            echo "Error while executing query: $stmt<br>" . PHP_EOL;
                            echo "Debugging errno: " . mysqli_connect_errno() . "<br>" . PHP_EOL;
                            echo "Debugging error: " . mysqli_connect_error() . "<br>" . PHP_EOL;
                            exit;
                        }
                        if ($userID === $name ) {
                            array_push($errorList, "User name not available, please select another one.");
                        }
                    }
                    // Test e-mail
                    if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
                        array_push($errorList, "E-mail looks invalid.");
                    }elseif (strlen($pass1) > 150) {
                        array_push($errorList, "E-mail must not be more than 150 characters long.");
                    }
                    // Test passwords
                    if ($pass1 !== $pass2){
                        array_push($errorList, "Passwords do not match.");
                    } elseif (strlen($pass1) < 6){
                        array_push($errorList, "Password must be at least 6 characters long.");
                    } elseif (strlen($pass1) > 64) {
                        array_push($errorList, "Password must not be more than 64 characters long.");
                    } elseif (!(preg_match('/[A-Z]/', $pass1)AND preg_match('/[a-z]/', $pass1) AND preg_match('/\d/', $pass1))) {
                        array_push($errorList, "Password must have at least one uppercase letter, one lower case letter, and one number.");
                    }
                    if($errorList) {
                        echo getForm($name, $email) . "\n";
                        echo '</div>';
                        ?>
    
            <div class="register_error">
                <h3>Registration Failed</h3>
                        <?php
                        // displays errors to the user
                        echo '<ul>';
                        foreach($errorList as $error) {
                            echo '<li>' . $error . '</li>';
                        }
                        echo '</ul>';
                        echo '</div>';
                        ?>
                <?php
                // Inserts register on the database
                } else {
                    $query = "INSERT INTO user (userID, name, email, password) VALUE( NULL, ?, ?, ?);";
                    $stmt = mysqli_prepare($dbc, $query);
                    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $pass1 );
                    $result = mysqli_stmt_execute($stmt);
                    /*  check the result */
                    if (!$result) {
                        echo "Error while executing query: $stmt<br>" . PHP_EOL;
                        echo "Debugging errno: " . mysqli_connect_errno() . "<br>" . PHP_EOL;
                        echo "Debugging error: " . mysqli_connect_error() . "<br>" . PHP_EOL;
                        exit;
                    }
                    echo '<div class="register">';
                    echo '<p>You have been successfully registered.<p>';
                    echo '<p>Click <a href="login.php">here</a> to Login.</p>';
                    echo '</div>';
                }
            }
            require 'lib/footer.php';
            ?>
    </body>
</html>