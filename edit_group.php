<?php
/**
 * InviMailer - PHP mailing application.
 * @copyright 2014 Jakub 'Horuss' Czajkowski
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 */
require('includes/login_check.php');
if (!isset($_POST['group'])) {
    header("location:index.php");
    exit;
}
require('includes/functions.php');

editGroup($_POST['group'], $_POST['mails'], $_FILES['csv']);
header('location:group.php?group=' . $_POST['group']);
exit;
