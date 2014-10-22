<?php
/**
 * InviMailer - PHP mailing application.
 * @copyright 2014 Jakub 'Horuss' Czajkowski
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 */
require('includes/login_check.php');
if (!(isset($_POST['projectId']) and isset($_POST['eventName']))) {
    header("location:index.php");
    exit;
}
require('includes/header.php');
require('includes/functions.php');
require('phpmailer/PHPMailerAutoload.php');
require('_config.php');

$eventName = $_POST['eventName'];
$projectId = $_POST['projectId'];
$mail = new PHPMailer;

$mail->From = 'mailbot@student.agh.edu.pl';
$mail->FromName = $_SESSION['username'];

if($config['mailing']['smtp']['isSMTP']) {
    $mail->isSMTP();
    $mail->Host = $config['mailing']['smtp']['Host'];
    $mail->SMTPAuth = $config['mailing']['smtp']['SMTPAuth'];
    $mail->Username = $config['mailing']['smtp']['Username'];
    $mail->Password = $config['mailing']['smtp']['Password'];
    $mail->SMTPSecure = $config['mailing']['smtp']['SMTPSecure'];
    $mail->Port = $config['mailing']['smtp']['Port'];
}
$mailsTo = array();

$arr = explode(',', $_POST['to']);
foreach ($arr as $value) {
    $value = trim($value);
    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
        $mailsTo[] = $value;
    }
}
if ($_POST['toGroup'] != 0) {
    $arr = getGroupMailsArray($_POST['toGroup']);
    foreach ($arr as $value) {
        $mailsTo[] = $value;
    }
}
$arr = explode(',', $_POST['cc']);
foreach ($arr as $value) {
    $value = trim($value);
    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
        $mail->addCC($value);
    }
}
if ($_POST['ccGroup'] != 0) {
    $arr = getGroupMailsArray($_POST['ccGroup']);
    foreach ($arr as $value) {
        $mail->addCC($value);
    }
}
$arr = explode(',', $_POST['bcc']);
foreach ($arr as $value) {
    $value = trim($value);
    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
        $mail->addBCC($value);
    }
}
if ($_POST['bccGroup'] != 0) {
    $arr = getGroupMailsArray($_POST['bccGroup']);
    foreach ($arr as $value) {
        $mail->addBCC($value);
    }
}

if ($_FILES['att']['size'] > 0) {
    for ($i = 0; $i < count($_FILES['att']['name']); $i++) {
        $mail->addAttachment($_FILES['att']['tmp_name'][$i], $_FILES['att']['name'][$i]);
    }
}

$mail->isHTML(true);
$mail->CharSet = 'UTF-8';
$mail->Subject = $_POST['subject'];

$mailsTo = array_unique($mailsTo);

?>

    <div id="cont">
        <h1>Event: '<? echo $eventName ?>'</h1>

        <form action="project.php" method="get">
            <h1>Mail</h1>
            <?
            $path = substr("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 0, -13);
            $query = "INSERT INTO `events` (projectId,name) VALUES ('$projectId','$eventName')";
            mysql_query($query) or die(mysql_error());
            $eventId = mysql_insert_id();
            foreach ($mailsTo as $currMail) {
                $mail->addAddress($currMail);
                $hashNo = md5($currMail . $eventId . 'no');
                $hashYes = md5($currMail . $eventId . 'yes');
                $hashOut = md5($currMail . $eventId . 'out');
                $mail->Body = $_POST['content'] .
                    '<p><a href="' . $path . 'response.php?hash=' . $hashYes . '">Accept</a></p>' .
                    '<p><a href="' . $path . 'response.php?hash=' . $hashNo . '">Refuse</a></p>' .
                    '<p><a href="' . $path . 'response.php?hash=' . $hashOut . '">Unsubscribe from mailing groups</a></p>';
                if (!$mail->send()) {
                    echo '<h3>Error sending to ' . $currMail . ': ' . $mail->ErrorInfo . '</h3>';
                } else {
                    echo '<h3>Succesfully sent to ' . $currMail . '</h3>';
                    $query = "INSERT INTO `event_records` (eventId,mail,status) VALUES ('$eventId','$currMail',0)";
                    mysql_query($query) or die(mysql_error());
                    $eventRecordId = mysql_insert_id();
                    $query = "INSERT INTO `event_hashes` (eventRecordId,hash,status) VALUES
                                    ('$eventRecordId','$hashYes',1),
                                    ('$eventRecordId','$hashNo',-1),
                                    ('$eventRecordId','$hashOut',-2)";
                    mysql_query($query) or die(mysql_error());
                }
                $mail->clearAddresses();
            }
            ?>
            <input type="hidden" name="project" value="<? echo $projectId ?>"/>
            <input type="submit" value="Back to project"/>
        </form>
    </div>

<?
require('includes/footer.php');
