<?php
/**
 * InviMailer - PHP mailing application.
 * @copyright 2014 Jakub 'Horuss' Czajkowski
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 */
require('includes/login_check.php');
if (!(isset($_SESSION['username']) and isset($_GET['project']))) {
    header("location:index.php");
    exit;
}
require('includes/header.php');
require('includes/functions.php');

$id = $_SESSION['userId'];
$projectId = $_GET['project'];
$projectName = getProjectName($projectId);
?>

<div id="cont">
    <h1>Project: '<? echo $projectName ?>'</h1>

    <h2>Mailing events</h2>

    <form action="event.php" method="get">
        <h1>Check responses</h1>
        <label><span>Name:</span>
            <select name="event">
                <?
                getEventsOptions($projectId);
                ?>
            </select></label>
        <input type="hidden" name="projectId" value="<? echo $projectId ?>"/>
        <label><span></span><input type="submit" value="Select"/></label>
    </form>

    <form action="add_event.php" method="post">
        <h1>Create new</h1>
        <input type="hidden" name="projectId" value="<? echo $projectId ?>"/>

        <label><span>Name:</span>
            <input type="text" id="eventName" name="eventName"/></label>
        <label><span></span><input type="submit" value="Create"/></label>
    </form>

    <form action="dashboard.php" method="post">
        <input type="submit" value="Back to dashboard"/>
    </form>
</div>

<?
require('includes/footer.php');