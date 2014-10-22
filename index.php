<?php
/**
 * InviMailer - PHP mailing application.
 * @copyright 2014 Jakub 'Horuss' Czajkowski
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 */
require('includes/index_check.php');
require('includes/functions.php');

if (isset($_POST['username']) and isset($_POST['password'])) {
    if (login($_POST['username'], $_POST['password'])) {
        header("location:dashboard.php");
        exit;
    } else {
        header("location:index.php?error=true");
        exit;
    }
} else {

    require('includes/header.php');
    ?>

    <div id="cont">
        <h1>Login</h1>
        <?
        if ($_GET['error'] == true) {
            ?>
            <h3 class="error">Invalid credentials - try again</h3>
        <?
        }
        ?>

        <form method="post" action="index.php">
            <h1>Login</h1>
            <label><span>Login:</span><input type="text" name="username"/></label>
            <label><span>Password:</span><input type="password" name="password"/></label>
            <label><span></span><input type="submit" value="Zaloguj"/></label>
        </form>
    </div>

    <?
    require('includes/footer.php');
}