<?php
/**
 * InviMailer - PHP mailing application.
 * @copyright 2014 Jakub 'Horuss' Czajkowski
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 */
require('includes/login_check.php');
if (!(isset($_POST['projectName']) and trim($_POST['projectName']) != false)) {
    header("location:index.php");
    exit;
}
require('includes/header.php');
require('includes/functions.php');

$id = $_SESSION['userId'];
$projectName = $_POST['projectName'];

addProject($id, $projectName);
?>

<div id="cont">
    <h1>New project</h1>

    <form method="get" action="dashboard.php">
        <h1>Project</h1>

        <h3>Created project '<? echo $projectName ?>'</h3>
        <input type="submit" value="Back to dashboard"/>
    </form>
</div>

<?
require('includes/footer.php');
