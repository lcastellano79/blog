<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>About This Blog</title>
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
        <h1 class="main_title">About This Blog</h1>
        <?php
            // Second part of HTML top bar
            include 'lib/head2.php';
            // Displays successful logout message and presents login link
            echo '<div class="login">';
            echo '<p>This Blog is just for fun!!</p>';
            echo '</div>';
            // Page Footer
            include 'lib/footer.php';
?>

    </body>