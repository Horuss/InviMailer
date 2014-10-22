<?php
/**
 * InviMailer - PHP mailing application.
 * @copyright 2014 Jakub 'Horuss' Czajkowski
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 */
require('db.php');

function getProjectName($projectId)
{
    $query = "SELECT * FROM `projects` WHERE id='$projectId'";
    $result = mysql_query($query) or die(mysql_error());
    $name = mysql_result($result, 0, "name");
    return $name;
}

function getEventName($eventId)
{
    $query = "SELECT * FROM `events` WHERE id='$eventId'";
    $result = mysql_query($query) or die(mysql_error());
    $name = mysql_result($result, 0, "name");
    return $name;
}

function getGroupName($groupId)
{
    $query = "SELECT * FROM `groups` WHERE id='$groupId'";
    $result = mysql_query($query) or die(mysql_error());
    $name = mysql_result($result, 0, "name");
    return $name;
}

function getGroupMailsString($groupId)
{
    $query = "SELECT * FROM `group_mails` WHERE groupId='$groupId'";
    $result = mysql_query($query) or die(mysql_error());
    $currentMails = "";
    while ($row = mysql_fetch_assoc($result)) {
        $currentMails .= $row['mail'] . PHP_EOL;
    }
    return $currentMails;
}

function getGroupMailsArray($groupId)
{
    $query = "SELECT * FROM `group_mails` WHERE groupId='$groupId'";
    $result = mysql_query($query) or die(mysql_error());
    $mails = array();
    while (($row = mysql_fetch_assoc($result))) {
        $mails[] = $row['mail'];
    }
    return $mails;
}

function printGroupsOptions($userId)
{
    $query = "SELECT * FROM `groups` WHERE userId='$userId'";

    $result = mysql_query($query) or die(mysql_error());
    while ($row = mysql_fetch_assoc($result)) {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
}

function printProjectsOptions($userId)
{
    $query = "SELECT * FROM `projects` WHERE userId='$userId'";

    $result = mysql_query($query) or die(mysql_error());
    while ($row = mysql_fetch_assoc($result)) {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
}

function getEventsOptions($projectId)
{
    $query = "SELECT * FROM `events` WHERE projectId='$projectId'";

    $result = mysql_query($query) or die(mysql_error());
    while ($row = mysql_fetch_assoc($result)) {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
}

function getEventRecordsRows($eventId)
{
    $query = "SELECT * FROM `event_records` WHERE eventId='$eventId'";

    $result = mysql_query($query) or die(mysql_error());
    while ($row = mysql_fetch_assoc($result)) {
        $img = 'Help';
        switch ($row['status']) {
            case 1:
                $img = 'OK';
                break;
            case -1:
                $img = 'Cancel';
                break;
        }
        $img = "img/" . $img . ".png";
        echo '<tr><td>' . $row['mail'] . '</td><td class="align-center"><img src="' . $img . '" /></td></tr>';
    }
}

function addGroup($id, $groupName) {
    $query = "INSERT INTO `groups` (userId,name) VALUES ('$id','$groupName')";

    mysql_query($query) or die(mysql_error());
}

function addProject($id, $projectName) {
    $query = "INSERT INTO `projects` (userId,name) VALUES ('$id','$projectName')";

    mysql_query($query) or die(mysql_error());
}

function editGroup($groupId, $mails, $file)
{
    $arr = explode(PHP_EOL, $mails);
    $query = "DELETE FROM `group_mails` WHERE groupId='$groupId'";
    mysql_query($query) or die(mysql_error());
    foreach ($arr as $value) {
        $value = trim($value);
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $query = "INSERT IGNORE INTO `group_mails` (groupId,mail) VALUES ('$groupId','$value')";
            mysql_query($query) or die(mysql_error());
        }
    }
    if ($file['size'] > 0) {
        $arr = str_getcsv(file_get_contents($file['tmp_name']));
        foreach ($arr as $value) {
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $query = "INSERT IGNORE INTO `group_mails` (groupId,mail) VALUES ('$groupId','$value')";
                mysql_query($query) or die(mysql_error());
            }
        }
    }
}

function login($username, $password) {
    $password = md5($password);

    $query = "SELECT * FROM `users` WHERE username='$username' and password='$password'";

    $result = mysql_query($query) or die(mysql_error());
    $count = mysql_num_rows($result);

    if ($count == 1) {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['userId'] = mysql_result($result, 0, "id");
        return true;
    } else {
        return false;
    }
}

function checkResponse($hash) {
    $query = "SELECT * FROM `event_hashes` WHERE hash='$hash'";
    $result = mysql_query($query) or die(mysql_error());
    if (mysql_num_rows($result) != 0) {
        $status = mysql_result($result, 0, "status");
        $eventRecordId = mysql_result($result, 0, "eventRecordId");
        if ($status == -2) {
            $query = "SELECT * FROM `event_records` WHERE id='$eventRecordId'";
            $result = mysql_query($query) or die(mysql_error());
            $mail = mysql_result($result, 0, "mail");
            $query = "DELETE FROM `group_mails` WHERE mail='$mail'";
            mysql_query($query) or die(mysql_error());
        } else {
            $query = "UPDATE `event_records` SET status='$status' WHERE id='$eventRecordId'";
            mysql_query($query) or die(mysql_error());
        }
        return $status;
    } else {
        return 0;
    }
}