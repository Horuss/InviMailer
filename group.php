<?php
/**
 * InviMailer - PHP mailing application.
 * @copyright 2014 Jakub 'Horuss' Czajkowski
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 */
require('includes/login_check.php');
if (!(isset($_GET['group']))) {
    header("location:index.php");
    exit;
}
require('includes/header.php');
require('includes/functions.php');

$id = $_SESSION['userId'];
$groupId = $_GET['group'];
$groupName = getGroupName($groupId);

$currentMails = getGroupMailsString($groupId);
?>

<div id="cont">
    <h1>Mailing group: '<? echo $groupName ?>'</h1>

    <form enctype="multipart/form-data" action="edit_group.php" method="post">
        <h1>Mailing group</h1>

        <h3>You can add e-mail addresses to group by typing it here (each in one line) and/or importing them from CSV file</h3>
        <textarea name="mails" rows="6" cols="50"><? echo $currentMails ?></textarea>
        <input type="hidden" name="MAX_FILE_SIZE" value="30000"/>

        <label><span>CSV file:</span><input type="file" id="csv" name="csv"/></label>
        <input type="hidden" name="group" value="<? echo $groupId ?>"/>
        <label><span></span><input type="submit" value="Save"/></label>

    </form>

    <form action="dashboard.php" method="post">
        <input type="submit" value="Back to dashboard"/>
    </form>
</div>

<?
require('includes/footer.php');