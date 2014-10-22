<?php
/**
 * InviMailer - PHP mailing application.
 * @copyright 2014 Jakub 'Horuss' Czajkowski
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 */
session_start();
if (isset($_SESSION['username'])) {
    header("location:dashboard.php");
    exit;
}