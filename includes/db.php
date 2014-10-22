<?php
/**
 * InviMailer - PHP mailing application.
 * @copyright 2014 Jakub 'Horuss' Czajkowski
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 */
require('_config.php');

$connection = mysql_connect($config['db']['host'], $config['db']['username'], $config['db']['password']);
if (!$connection) {
    die("Database Connection Failed" . mysql_error());
}
$select_db = mysql_select_db($config['db']['dbname']);
if (!$select_db) {
    die("Database Selection Failed" . mysql_error());
}