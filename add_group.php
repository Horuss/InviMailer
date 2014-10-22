<?php
/**
 * InviMailer - PHP mailing application.
 * @copyright 2014 Jakub 'Horuss' Czajkowski
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 */
require('includes/login_check.php');
if (!(isset($_POST['groupName']) and trim($_POST['groupName']) != false)) {
    header("location:index.php");
    exit;
}
require('includes/header.php');
require('includes/functions.php');

$id = $_SESSION['userId'];
$groupName = $_POST['groupName'];

addGroup($id, $groupName);
?>

<div id="cont">
    <h1>New mailing group</h1>

    <form method="get" action="dashboard.php">
        <h1>Mailing group</h1>

        <h3>Created mailing group '<? echo $groupName ?>'</h3>
        <input type="submit" value="Back to dashboard"/>
    </form>
</div>

<?
require('includes/footer.php');