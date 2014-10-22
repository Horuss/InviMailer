<?php
/**
 * InviMailer - PHP mailing application.
 * @copyright 2014 Jakub 'Horuss' Czajkowski
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 */
require('includes/login_check.php');
require('includes/header.php');
require('includes/functions.php');

$username = $_SESSION['username'];
$id = $_SESSION['userId'];
?>

<div id="cont">
    <h1>Dashboard '<? echo $username ?>'</h1>

    <h2>Projects</h2>

    <form method="get" action="project.php">
        <h1>Choose project</h1>
        <label><span>Name:</span>
            <select name="project">
                <?
                printProjectsOptions($id);
                ?>
            </select></label>
        <label><span></span>
            <input type="submit" value="Select"/>
        </label>
    </form>

    <form method="post" action="add_project.php">
        <h1>Create new</h1>
        <label><span>Name:</span>
            <input type="text" name="projectName"/></label>
        <label><span></span><input type="submit" value="Create"/></label>
    </form>

    <h2>Mailing groups</h2>

    <form method="get" action="group.php">
        <h1>Choose group</h1>
        <label><span>Name:</span>
            <select name="group">
                <?
                printGroupsOptions($id);
                ?>
            </select></label>
        <label><span></span><input type="submit" value="Select"/></label>
    </form>

    <form method="post" action="add_group.php">
        <h1>Create new</h1>
        <label><span>Name:</span>
            <input type="text" name="groupName"/></label>
        <label><span></span><input type="submit" value="Create"/></label>
    </form>

    <form method="post" action="logout.php">
        <input type="submit" value="Logout"/>
    </form>
</div>
<?
require('includes/footer.php');