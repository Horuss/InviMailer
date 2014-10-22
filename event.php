<?php
/**
 * InviMailer - PHP mailing application.
 * @copyright 2014 Jakub 'Horuss' Czajkowski
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 */
require('includes/login_check.php');
if (!(isset($_GET['event']))) {
    header("location:index.php");
    exit;
}
require('includes/header.php');
require('includes/functions.php');

$id = $_SESSION['userId'];
$eventId = $_GET['event'];
$eventName = getEventName($eventId);
?>

<div id="cont">
    <h1>Mailing event: '<? echo $eventName ?>'</h1>

    <form method="get" action="project.php">
        <h1>Responses</h1>
        <table>
            <thead>
            <tr>
                <th>Mail</th>
                <th>Response</th>
            </tr>
            </thead>
            <tbody>
            <?
            getEventRecordsRows($eventId);
            ?>
            </tbody>
        </table>
        <p><img src="img/OK.png"/> - accept, <img src="img/Cancel.png"/> - refuse, <img
                src="img/Help.png"/> - no answer</p>
        <input type="hidden" name="project" value="<? echo $_GET['projectId'] ?>"/>
        <input type="submit" value="Back to project"/>
    </form>
</div>

<?
require('includes/footer.php');