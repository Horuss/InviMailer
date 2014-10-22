<?php
/**
 * InviMailer - PHP mailing application.
 * @copyright 2014 Jakub 'Horuss' Czajkowski
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 */
if (!isset($_GET['hash'])) {
    header("location:index.php");
    exit;
}
require('includes/header.php');
require('includes/functions.php');
    ?>

    <div id="cont">
    <h1>Response</h1>

        <?
        switch (checkResponse($_GET['hash'])) {
            case 1:
                echo '<h3>Accepted</h3>';
                break;
            case -1:
                echo '<h3>Refused</h3>';
                break;
            case -2:
                echo '<h3>Unsubscribed from mailing groups</h3>';
                break;
            default:
                echo '<h3>No action</h3>';
        }

        ?>
    </div>

<?
require('includes/footer.php');
