<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Main page of the blog</title>
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
        <h1 class="main_title">Welcome to my blog, read on!</h1>
        <?php
            // Second part of HTML top bar
            require 'lib/head2.php';
        ?>
        <div class="content">
                        <?php
                            echo '<div class="addnew">';
                            if (isset($_SESSION['user'])) {
                                echo '<h6>Post a new article <a href="articleadd.php">here</a></h6>';
                            }
                            echo '</div>';
                        ?>
                <div class="article">
                        <?php
                            // Selects the last articles (only 5 most recent)
                            $query = "SELECT article.articleID, article.creationTime, article.title, article.body, user.name  from user, article where article.authorID = user.userID ORDER BY article.creationTime DESC LIMIT 5;";
                            $result = mysqli_query($dbc, $query);
                            // Checks errors
                            if (!$result) {
                                    echo "Error while executing query: $result <br>" . PHP_EOL;
                                    echo "Debugging errno: " . mysqli_connect_errno() . "<br>" . PHP_EOL;
                                    echo "Debugging error: " . mysqli_connect_error() . "<br>" . PHP_EOL;
                                    exit;
                            } elseif (mysqli_num_rows($result) > 0) {
                                // Presents articles (Title + date + first 200 characters)
                                echo '<ul>';
                                while ($row = mysqli_fetch_row($result)) {
                                    echo '<li class="post">';
                                    echo '<h2> <a href="article.php?articleID=' . $row[0] . '">' . $row[2] . '</a> </h2>';
                                    echo '<h3> Posted by ' . $row[4] . ' on ' . date( 'M/d, Y', strtotime($row[1])) . ' at '. date( 'G:i', strtotime($row[1])) . '</h3>';
                                    echo substr($row[3], 0, 200) . '<a href="article.php?articleID=' . $row[0] . '">[...]</a>';
                                    echo '</li>';
               
                                }
                                echo '</ul>';
                            } else {
                                echo '<h5>There are no articles</h5>';
                            }

                        ?>
                </div>
            </div>
                <?php
                    // Page footer
                    require 'lib/footer.php';
                ?>
    </body>
</html>
