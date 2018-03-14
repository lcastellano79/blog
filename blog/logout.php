<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>User Logout</title>
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
        <h1 class="main_title">User Logout</h1>
        <?php
            // Displays successful logout message and presents login link
            unset($_SESSION['person']);
            session_unset();
            // Second part of HTML top bar
            include 'lib/head2.php';
            echo '<div class="login">';
            echo '<p>You have been successfully logged out.<p>';
            echo '<p>Click <a href="login.php">here</a> to login</p>';
            echo '</div>';
            // Page Footer
            include 'lib/footer.php';
?>

    </body>

