                <div class="session">
                    <?php
                    if (isset($_SESSION['user'])) {
                        echo '<p><br>You are logged in as ' . $_SESSION['user'] . '. <a href="logout.php">Logout</a></p>';
                    } else {
                        echo '<p><br><a href="login.php">Login</a> or <a href="register.php">Register</a> to post articles and comments</p>';
                    }
                    ?>
                </div>
                <div class="clear">
                </div>
            </header>
            <div class="banner">
                <a href="https://www.ielts.org/book-a-test/find-a-test-location"> <img src="images/banner.gif" alt=“advertisement_banner” width="728" height="90"> </a>
            </div>
