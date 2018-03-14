<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Contact Information</title>
        <?php
            // css file and Google fonts references
            require 'lib/references.php';
        ?>
    </head>
    <body>
        <?php
            // First part of HTML top bar
            require 'lib/head1.php';
        ?>
        <h1 class="main_title">Contact Information</h1>
        <?php
            // Second part of HTML top bar
            include 'lib/head2.php';
            // Displays successful logout message and presents login link
            echo '<div class="login">';
            echo '<p>Larissa Castellano</p>';
            echo '<p>e-mail: <a href="mailto:lcastellano@gmail.com">lcastellano@gmail.com</a>';
            echo '</div>';
            // Page Footer
            include 'lib/footer.php';
?>

    </body>