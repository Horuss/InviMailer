<?php
/**
 * InviMailer - PHP mailing application.
 * @copyright 2014 Jakub 'Horuss' Czajkowski
 * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
 */
require('includes/login_check.php');
if (!(isset($_POST['eventName']) and trim($_POST['eventName']) != false)) {
    header('location:project.php?project=' . $_POST['projectId']);
    exit;
}
require('includes/header.php');
require('includes/functions.php');
require('_config.php');

$id = $_SESSION['userId'];
$eventName = $_POST['eventName'];
?>

<script src="<?echo $config['paths']['tinyMCE']?>"></script>
<script>tinymce.init({
        selector: 'textarea.mce',
        plugins: "textcolor",
        toolbar: "undo redo | styleselect | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent blockquote | removeformat",
        menubar: false,
        width: 490,
        statusbar: false
    });</script>
<div id="cont">
    <h1>New mailing event: '<? echo $eventName ?>'</h1>

    <form method="post" action="send_mail.php" enctype="multipart/form-data">
        <h1>Mail</h1>

        <h3>You can choose group and/or enter additional addresses (comma-separated).</h3>

        <label><span>To (group):</span><select name="toGroup">
                <option value="0">(empty)</option>
                <? printGroupsOptions($id) ?>
            </select></label>
        <label><span>To (others):</span><input type="text" name="to"/></label>

        <label><span>CC (group):</span><select name="ccGroup">
                <option value="0">(empty)</option>
                <? printGroupsOptions($id) ?>
            </select></label>
        <label><span>CC (others):</span><input type="text" name="cc"/></label>

        <label><span>BCC (group):</span><select name="bccGroup">
                <option value="0">(empty)</option>
                <? printGroupsOptions($id) ?>
            </select></label>
        <label><span>BCC (others):</span><input type="text" name="bcc"/></label>

        <label><span>Subject:</span><input type="text" name="subject"/></label>
        <label>
            <textarea name="content" class="mce"></textarea>
        </label>

        <label><span>Attachments:</span><input multiple type="file" name="att[]" "/></label>

        <input type="hidden" name="projectId" value="<? echo $_POST['projectId'] ?>"/>
        <input type="hidden" name="eventName" value="<? echo $_POST['eventName'] ?>"/>
        <label><span></span><input type="submit" value="Send"/></label>
    </form>

    <form action="project.php" method="get">
        <input type="hidden" name="project" value="<? echo $_POST['projectId'] ?>"/>
        <input type="submit" value="Back to project"/>
    </form>
</div>

<?
require('includes/footer.php');